<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Input;

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
    protected $redirectTo = '/';



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
        if(env('GOOGLE_RECAPTCHA_KEY') != null && env('GOOGLE_RECAPTCHA_SECRET') != null) 
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
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['register-username'],
            'email' => $data['register-email'],
            'password' => bcrypt($data['register-password']),
            'role' => 'user',
            'remember_token' => null 
        ]);
    }


    public function register(Request $request)
    {
        $validation = $this->validator($request->all());

        if ($validation->fails()) 
        {            
            return redirect()->back()->withErrors($validation, 'register')->withInput(Input::except('register-password', 'register-password_confirmation', '_token'));
        }
        else
        {

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
        }
    }
}
