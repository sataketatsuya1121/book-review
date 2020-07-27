<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::APP;

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
     * 新規登録で送信されたリクエストをバリデーション[オーバーライド]
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'name' => 'required|string|max:30',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string|min:8',
                'avatar' => 'string|min:8',
            ],
            [
                'required' => '入力必須の項目です',
                'max' => ':max 以下の文字で設定してください',
                'min' => '少なくとも :min 文字以上でパスワードを設定してください',
                'unique' => 'このメールアドレスはすでに登録されています',
                'confirmed' => '入力したパスワードが一致していません'
            ]
        );
    }

    /**
     * バリデーション通過後、新しくUser作成
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'api_token' => Str::random(60),
        ]);
    }

    /**
     * RegistersUsersトレイトのregisterdメソッドをオーバーライド
     * 登録完了後、全てのユーザーにメール通知
     * クッキーにapiトークンをセット
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse|Response
     */
    protected function registered(Request $request, User $user)
    {
        $notificationService = new NotificationService();
        $notificationService->mailRegisteredUsers($user);

        DB::update('update users set api_token = ? where email = ?', [$user->api_token, $user->email]);
        setcookie('api_token', $user->api_token);

        return $request->wantsJson()
                    ? new Response('', 201)
                    : redirect($this->redirectPath());
    }
}
