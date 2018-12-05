<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 管理员登陆
     *
     * @return mixed
     */
    public function login()
    {
        echo 'login';
        return view('admin.login.home');
    }

    /**
     * 展示会员管理列表
     */
    public function show(int $id)
    {
        $info = $this->userService->checkUser($id);

        echo json_encode($info);
    }

    /**
     * 注册用户
     *
     * uname
     * email
     * phone
     * password
     *
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'uname'    => 'required|min:3|max:18|unique:users,nickname',
            'password' => 'required|min:5|max:18|confirmed',
            'password_confirmation' => 'required|min:5|max:18',
        ]);
        $uname      = $request->input('uname');
        $password   = $request->input('password');
        $repassword = $request->input('password_confirmation');
        if (strcasecmp($password, $repassword) !=0 ) {
            exit('fail');
        }

        $data = compact('uname','password');
        $data['identifier_type'] = 'www';//weixin webo www qq

        $this->userService->createUser($data);

        //return redirect('/login');
        return view('admin.users.add');
    }

    //更改用户信息
    public function edit(Request $request)
    {
        $this->validate($request, [
//            'uname' => 'required|min:3|max:18|unique:users,nickname',
            'phone'=>'required|unique:users,phone|phone',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:5|max:18|confirmed',
            'password_confirmation' => 'required|min:5|max:18',
        ]);
        //$email = $request->input('email');
        //$phone = $request->input('phone');
        compact('uname','password','repassword');
        echo 'edit';
    }
}
