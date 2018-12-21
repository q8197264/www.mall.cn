<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\AppServices\Services\UserService;

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
    protected $redirectTo = '/home';

    protected $userService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('guest');
        $this->userService = $userService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * 注册用户
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        //event(new RegisterEmail($user));//注册成功触发RegisterEmail事件，邮件通知

        return $user;
    }

    /**
     * 用户注册
     *
     * @param Request $request
     *
     * @return redirect url
     */
    public function register(Request $request)
    {
        $validator=$this->validator($request->all());
        if ($validator->fails()){
            dd('validator fail');
        }
        $username     = $request->input('name');
        $email    = $request->input('email');
        $password = $request->input('password');
        $data = compact('username','email','password');
        $uid = $this->userService->register($data);

        if (empty($uid)) {
            return view('auth.register');
        }

        return redirect('frontend.home');
    }
}
