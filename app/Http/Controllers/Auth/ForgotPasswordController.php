<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
     * バリデーションエラーメッセージ[オーバーライド]
     *
     * @param Request $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'required' => '入力必須の項目です',
        ]);
    }

    /**
     * リクエスト成功時のメッセージ[オーバーライド]
     * 日本語に翻訳
     *
     * @param Request $request
     * @param [type] $response
     * @return void
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return $request->wantsJson()
                    ? new JsonResponse(['message' => trans($response)], 200)
                    : back()->with('status', trans('メールアドレス宛にパスワードリセットURLを送信しました'));
    }

    /**
     * リクエスト失敗時のエラーメッセージ[オーバーライド]
     * 日本語に翻訳
     *
     * @param Request $request
     * @param [type] $response
     * @return void
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }

        return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans('このメールアドレスは登録されていません')]);
    }
}
