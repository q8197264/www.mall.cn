<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Extensions\AuthenticatesLogout;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\AppServices\Services\AdministratorService;

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

    protected $administratorService;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdministratorService $administratorService)
    {
        $this->middleware('guest:admin', ['except' => 'logout']);
        //$this->username = config('admin.global.username');
        $this->administratorService = $administratorService;
    }

    /**
     * 显示后台登录模板
     */
    public function showLoginForm(Request $request)
    {
        echo $request->session()->get('user_id');
        //echo $request->session()->get('username');

        return view('admin.login');
    }

    /**
     * 使用 admin guard
     */
    protected function guard()
    {
        return auth()->guard('admin');
    }

    /**
     * 重写验证时使用的用户名字段
     */
    public function username()
    {
        return 'uname';
    }

    /**
     * 检测管理员登陆
     *
     * @param Request $request
     */
    public function authenticate(Request $request)
    {
        //$this->validateLogin($request);//数据验证
//        $this->validate($request, [
//            $this->username() => 'required|string',
//            'password' => 'required|string',
//        ]);

        $username   = Request('uname');
        $password   = Request('password');
        $is_memeber = Request('is_remember');

        //plan B: use custom service
        $userdata = $this->administratorService->checkLogin($username, $password);

        //plan A: use laravel check `admins` table
        //dd(\Auth::guard('admin')->attempt([ 'uname' => $username,'password'=>'admin']));
//        \Auth::guard('admin')->attempt([ 'uname' => $username,'password'=>'admin']);

        switch ($userdata['code']) {
            case 0:
                $userdata['msg'] = 'success';
                $request->session()->put('user_id', $userdata['uid']);
                $request->session()->put('username', $username);

                return redirect('/admin/index');
                break;
            case 1:
                $userdata['msg'] = 'user no exists';
                break;
            case 2:
                $userdata['msg'] = 'password fail';
                break;
        }

        return redirect('/admin/login')->with('error', '账号或密码错误');
    }

//    public function logout(Request $request)
//    {
//        if ($request->session()->has('user_id')) {
//            //删除session中的数据项
//            $request->session()->forget('user_id'); //删除指定数据项数据
//            $request->session()->flush(); //删除所有数据
//            //重新生成sessionID
//            $request->session()->regenerate();
//        }
//    }
}
