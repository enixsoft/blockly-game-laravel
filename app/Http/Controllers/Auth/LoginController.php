<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function validateLogin(Request $request)
    {
        $this->validate($request, [
            'login-username' => 'required|string',
            'login-password' => 'required|string',
        ]);
    }

    public function credentials(Request $request)
    {

        $credentials = $request->only('login-username', 'login-password');
        $credentials['username'] = $credentials['login-username'];
        $credentials['password'] = $credentials['login-password'];
        unset($credentials['login-username']);
        unset($credentials['login-password']);
        return $credentials;
       
    }

    public function username()
    {
        return 'username';
    }

}
