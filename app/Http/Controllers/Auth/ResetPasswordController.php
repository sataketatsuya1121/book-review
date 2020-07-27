<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::APP;

    /**
     * パスワードリセットで送信されたリクエストをバリデーション[オーバーライド]
     *
     * @return void
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|string|email|max:255',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8',
        ];
    }

    /**
     * パスワードリセットのバリデーションエラーメッセージ[オーバーライド]
     *
     * @return void
     */
    protected function validationErrorMessages()
    {
        return [
            'required' => '入力必須の項目です',
            'max' => ':max 以下の文字で設定してください',
            'min' => '少なくとも :min 文字以上でパスワードを設定してください',
            'confirmed' => '入力したパスワードが一致していません'
        ];
    }
}
