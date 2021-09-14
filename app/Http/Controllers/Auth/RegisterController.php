<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if(config('app.google_recaptcha_key') != null && config('app.google_recaptcha_secret') != null) 
        {
            return Validator::make($data, [
                'register-username' => 'required|string|max:255|unique:users,username',
                'register-email' => 'required|string|email|max:255|unique:users,email',
                'register-password' => 'required|string|min:6|confirmed',
                'g-recaptcha-response'=>'required|recaptcha'
            ]); 
        }
        return Validator::make($data, [
            'register-username' => 'required|string|max:255|unique:users,username',
            'register-email' => 'required|string|email|max:255|unique:users,email',
            'register-password' => 'required|string|min:6|confirmed'
        ]); 
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\ModelsUser
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['register-username'],
            'email' => $data['register-email'],
            'password' => bcrypt($data['register-password']),
            'role' => 'user',
            'remember_token' => null 
        ]);
    }
}
