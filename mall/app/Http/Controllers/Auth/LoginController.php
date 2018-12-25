<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Extensions\AuthenticatesLogout;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\AppServices\Services\UserService;
use Libraries\Wechat;

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

    use AuthenticatesUsers, AuthenticatesLogout {
        AuthenticatesLogout::logout insteadof AuthenticatesUsers;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home/index';

    protected static $auth;
    protected $userService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->userService = $userService;
        //(new Wechat\Wechat())->Index();//微信服务器配置连接
        static::$auth = new Wechat\Authorize();
    }

    /**
     * 重写验证时使用的用户名字段
     */
    public function username()
    {
        return 'username';
    }

    protected function redirectTo()
    {
        return $this->redirectTo;
    }

    /**
     * 微信授权登陆
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function index()
    {
//        if (!empty(session('user_id'))) {
//            return redirect('/home');
//        }
//        return view('auth.login');
//        exit;

        $openid = session('openid');
        if (empty($openid)) {
            static::$auth ->auth();
            static::$auth ->getOpenid() && session()->put('openid', static::$auth ->getOpenid());
        }

        $this->signin();
    }

    protected function signin()
    {
        $openid = session('openid');
        if (empty($openid)) {
            return redirect('/login');
        }
        $userdata = $this->userService->checkLogin($openid, '', 'wechat');
        switch ($userdata['code']) {
            case 0:
                $userinfo = static::$auth ->getUserInfo($userdata['identifier']);

                if (!empty($userinfo['nickname'])) {
                    session()->put('user_id', $userdata['uid']);
                    session()->put('nickname', $userinfo['nickname']);
                } else {
                    session()->forget('openid');
                }

                return redirect('/home');
                break;
            case 1:
                $uid = $this->userService->register(['identifier'=>$openid,'credential'=>'','grant_type'=>'wechat']);
                $userinfo = static::$auth ->getUserInfo($openid);
                if (!empty($userinfo['nickname'])) {
                    session()->put('user_id', $uid);
                    session()->put('nickname', $userinfo['nickname']);
                }else {
                    session()->forget('openid');
                }
                return redirect('/home');
                break;
            case 2:
                //$userdata['msg'] = 'password fail';
                break;
        }
    }

    /**
     * custom-made user login
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function authenticate(Request $request)
    {
        $user = Request(['uname','email','phone','password']);
        $username = array_shift($user);
        $password = array_shift($user);

        $userdata = $this->userService->checkLogin($username, $password, 'wechat');

        switch ($userdata['code']) {
            case 0:
                $userdata['msg'] = 'success';
                $request->session()->put('user_id', $userdata['uid']);
                $request->session()->put('username', $username);
                $request->session()->put('status', 1);

                return redirect('/home');
                break;
            case 1:
                $userdata['msg'] = 'user no exists';
                break;
            case 2:
                $userdata['msg'] = 'password fail';
                break;
        }

        return view('auth.login',['res'=>$userdata]);
    }

    public function logout(Request $request)
    {
        if ($request->session()->has('user_id')) {
            //删除session中的数据项
            $request->session()->forget('user_id'); //删除指定数据项数据
            $request->session()->flush(); //删除所有数据
            //重新生成sessionID
            $request->session()->regenerate();
        }
    }
}
