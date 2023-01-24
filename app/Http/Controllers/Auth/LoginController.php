<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Notifications\TwoFactorCode;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    protected $maxAttempts = 3; // Default is 5
    protected $decayMinutes = 2; // Default is 1
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

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required', 
            'password' => 'required',
            'captcha' => 'required|captcha'
            // new rules here
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin::auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
    }
}
