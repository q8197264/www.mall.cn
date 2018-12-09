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

    public function page()
    {
        return view('admin.users.users');
    }

    /**
     * 展示用户信息
     */
    public function show(Request $request)
    {
        $uid  = $request->input('uid');
        $list = $this->userService->show($uid);

        echo json_encode($list);
    }

    /**
     * 数据库未完
     * 展示用户列表
     */
    public function listing(int $offset, int $limit)
    {
        $list = $this->userService->getUserList($offset, $limit);

        echo json_encode($list);
    }

    /**
     * 注册用户
     *
     * uname
     * email
     * phone
     * password
     *
     * @return mixed
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'uname'    => 'required|min:3|max:18|unique:users,nickname',
            'password' => 'required|min:5|max:18|confirmed',
            'password_confirmation' => 'required|min:5|max:18',
        ]);
        $user      = $request->input('uname');
        $password   = $request->input('password');
        $repassword = $request->input('password_confirmation');
        if (strcasecmp($password, $repassword) !=0 ) {
            exit('fail');
        }
        $data = compact('user','password');
//        $data['grant_type'] = 'weibo';//weixin webo www qq

        $b = $this->userService->register($data);

        echo $b;
    }

    /**
     * 更改用户信息
     *
     * @param Request $request
     */
    public function edit(Request $request)
    {
        $this->validate($request, [
            'cid'       => 'required',
            'username'  => 'required|min:3|max:18|unique:users,nickname',
            'phone'     => 'required|unique:user_auths,identifier|phone',
            'email'     => 'required|unique:user_auths,identifier|email',
            'password'  => 'required|min:5|max:18|confirmed',
            'password_confirmation' => 'required|min:5|max:18',
        ]);
        $cid   = $request->input('cid');
        $uname = $request->input('username');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $password = $request->input('password');
        $data = compact('cid','email','phone','uname','password');
        print_r($data);
        exit();
        echo 'edit';
    }

    /**
     * 删除
     *
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $uid = $request->input('uid');
        $b = $this->userService->softDelete($uid);

        echo $b;
    }
}
