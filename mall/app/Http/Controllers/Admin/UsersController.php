<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\AppServices\Services\UserService;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 展示用户信息
     */
    public function show(int $uid=0)
    {
        $list = $this->userService->show($uid);

        echo json_encode($list);
    }

    /**
     * 数据库未完
     * 展示用户列表
     */
    public function list(int $offset=0)
    {
        $list = $this->userService->list($offset, 10);

        echo json_encode($list);
        return view('admin.users.users');
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
        $user       = $request->input('uname');
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
        echo '<pre>';
        $this->validate($request, [
            'id'        => 'required|numeric',
            'username'  => 'min:3|max:18',
//            'phone'     => 'numeric|min:11',
            'email'     => 'email',
            'password'  => 'required|min:5|max:18|confirmed',
            'password_confirmation' => 'required|alpha_dash|min:5|max:18',
        ]);
        $uid        = $request->input('id');
        $username   = $request->input('username');
        $phone      = $request->input('phone');
        $email      = $request->input('email');
        $password   = $request->input('password');
        $repassword = $request->input('password_confirmation');
        if (strcasecmp($password, $repassword) != 0) {
            $b =  '密码错误';
        } else {
            $where = compact('uid','username','phone','email','password');
            $b = $this->userService->edit($uid, $where);
        }

        echo $b;
    }

    /**
     * 删除
     *
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $uid = $request->input('id');
        $b = $this->userService->softDelete($uid);

        echo $b;
    }
}
