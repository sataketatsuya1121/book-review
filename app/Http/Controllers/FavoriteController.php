<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    private $favorite;
    private $user;

    public function __construct(Favorite $favorite, User $user)
    {
        $this->favorite = $favorite;
        $this->user = $user;
    }

    /**
     * お気に入りIDのお気に入り履歴を確認してすでに履歴があったらエラーハンドル
     * 履歴がなかったらお気に入りに登録
     *
     * @param integer $fav_user_id
     * @return void
     */
    public function favorite(int $fav_user_id)
    {
        if ($this->favorite->checkFavoriteDone($fav_user_id)) {
            return response()->json(config('const.abort'));
        }
        $this->favorite->storeFavorite($fav_user_id);
        return true;
    }

    /**
     * お気に入りIDのお気に入り履歴を確認して履歴がなかったらエラーハンドル
     * 履歴があったらお気に入りを解除
     *
     * @param integer $fav_user_id
     * @return void
     */
    public function unFavorite(int $fav_user_id)
    {
        if (!$this->favorite->checkFavoriteDone($fav_user_id)) {
            return response()->json(config('const.abort'));
        }
        $this->favorite->destroyFavoriteById($fav_user_id);
        return true;
    }
}
