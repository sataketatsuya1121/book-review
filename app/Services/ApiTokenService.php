<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class ApiTokenService
{
    /**
     * トークンを生成してデータベースに保存
     * 生成したトークンをクッキーに保存
     *
     * @param [type] $request
     * @return void
     */
    public function setApiTokenToCookie(string $email)
    {
        $apiToken = Str::random(60);
        DB::update('update users set api_token = ? where email = ?', [$apiToken, $email]);
        setcookie('api_token', $apiToken);
    }

    /**
     * クッキーに保存されているapi_tokenのデータを削除
     *
     * @return void
     */
    public function removeApiTokenFromCookie()
    {
        if (isset($_COOKIE['api_token'])) {
            setcookie('api_token', '', time()-60);
        }
    }
}
