<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * 外部サービスの認証ページへリダイレクトする。
     */
    public function redirectToProvider() {
//        return Socialite::driver('line')->redirect();
        $nonce_token = Str::random(40);

        return Socialite::driver('line')
            ->setScopes(['openid', 'profile'])
            ->with([
                'nonce' => $nonce_token,
            ])
            ->redirect();

    }

    /**
     * 外部サービスからユーザー情報を取得し、ログインする。
     */
    public function handleProviderCallback(Request $request) {
        $provider = 'line';
        $provided_user = Socialite::driver($provider)->stateless()->user();

        $user = User::firstOrCreate(
            ['line_mid' => $provided_user->id],
            ['name' => $provided_user->name]
        );

        $this->guard()->login($user, true);
        return $this->sendLoginResponse($request);
    }

}
