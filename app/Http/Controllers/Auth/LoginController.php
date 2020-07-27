<?php

namespace App\Http\Controllers\Auth;

use Hash;
use Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Providers\RouteServiceProvider;
use App\Services\ApiTokenService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::APP;

    protected $maxAttempts = 3;

    protected $apiTokenService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiTokenService $apiTokenService)
    {
        $this->middleware('guest')->except('logout');
        $this->apiTokenService = $apiTokenService;
    }

    /**
     * Github認証ページへ遷移
     *
     * @return void
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Socialiteを使った認証機能
     * GithubユーザーでUser登録、ログイン実装
     *
     * @return void
     */
    public function handleProviderCallback()
    {
        $socialUser = Socialite::driver('github')->stateless()->user();
        $user = User::where([ 'email' => $socialUser->getEmail() ])->first();

        if ($user) {
            Auth::login($user);
        } else {
            $user = User::create([
                'name' => $socialUser->getNickname(),
                'email' => $socialUser->getEmail(),
                'password' => Hash::make($socialUser->getNickname()),
            ]);
            Storage::putFileAs('public/profile_img/', $socialUser->getAvatar(), Auth::id() . '.jpeg');
            Auth::login($user);
        }

        // クッキーにapiトークンをセット
        $this->apiTokenService->setApiTokenToCookie($user->email);
        return redirect()->to(RouteServiceProvider::APP);
    }

    /**
     * Google認証ページへ遷移
     *
     * @return void
     */
    public function getGoogleAuth()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Socialiteを使った認証機能
     * GoogleユーザーでUser登録、ログイン実装
     *
     * @return void
     */
    public function authGoogleCallback()
    {
        $guser = Socialite::driver('google')->stateless()->user();
        $user = User::where([ 'email' => $guser->getEmail() ])->first();
        if ($user) {
            Auth::login($user);

            // クッキーにapiトークンをセット
            $this->apiTokenService->setApiTokenToCookie($user->email);
            return redirect()->to(RouteServiceProvider::APP);
        } else {
            $user = User::create([
                'name' => $guser->getNickName() ?? $guser->getName() ?? $guser->getNick(),
                'email' => $guser->getEmail(),
                'avatar' => $guser->getAvatar(),
                'password' => Hash::make($guser->getNickName() ?? $guser->getName() ?? $guser->getNick()),
            ]);
            Storage::putFileAs('public/profile_img/', $guser->getAvatar(), Auth::id() . '.jpeg');
            Auth::login($user);

            // クッキーにapiトークンをセット
            $this->apiTokenService->setApiTokenToCookie($user->email);
            return redirect()->to(RouteServiceProvider::APP);
        }
    }

    /**
     * ログイン時のバリデーションエラーメッセージ[オーバーライド]
     *
     * @param Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|string',
                'password' => 'required|string|min:8|',
            ],
            [
                'required' => '入力必須の項目です。',
                'min' => '少なくとも :min 文字以上でパスワードを設定してください',
            ]
        );
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        // クッキーにapiトークンをセット
        $this->apiTokenService->setApiTokenToCookie($request->email);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
                    ? new Response('', 204)
                    : redirect()->intended($this->redirectPath());
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('認証に失敗しました')],
        ]);
    }

    protected function loggedOut(Request $request)
    {
        // クッキーのapiトークンをリセット
        $this->apiTokenService->removeApiTokenFromCookie();
        return redirect(RouteServiceProvider::HOME);
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            $this->username() => [Lang::get('ログイン試行に失敗しすぎました。60秒間認証操作ができません', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ])],
        ])->status(Response::HTTP_TOO_MANY_REQUESTS);
    }
}
