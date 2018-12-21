<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppServices\Services\AdministratorService;

/**
 * 系统管理员模块.
 *
 * 1. 登陆
 * 2. 注册
 * 3. 管理员信息
 *
 * User: liuxiaoquan
 * Date: 2018-12-06
 * Time: 11:50
 */
class AdministratorController extends Controller
{
    protected $administratorService;

    public function __construct(AdministratorService $administratorService)
    {
        $this->administratorService = $administratorService;
    }

    /**
     * 管理员登陆页
     *
     * @return mixed
     */
    public function login(Request $request)
    {
        $res = $request->session()->get('user_id');
        var_dump('user id:', $res);
        return view('admin.administrator');
    }

    /**
     * 展示列表
     *
     * @param int $offset
     * @param int $limit
     */
    public function list(int $offset = 0)
    {
        $list = $this->administratorService->list($offset, 10);
        echo '<pre>';
        print_r($list);
    }

    /**
     * 检测管理员登陆
     *
     * @param Request $request
     */
    public function checkLogin(Request $request)
    {
        $uname    = $request->input('uname');
        $password = $request->input('password');
        $data     = $this->administratorService->checkLogin($uname, $password);
        switch ($data['code']) {
            case 0:
                $data['msg'] = 'success';
                $request->session()->put('user_id', $data['uid']);
                break;
            case 1:
                $data['msg'] = 'user no exists';
                break;
            case 2:
                $data['msg'] = 'password fail';
                break;
        }

        echo $data['msg'];
    }

    public function logOut(Request $request)
    {
//        $request->session()->forget('user_id');
//        return redirect('admin/login');
    }

    /**
     * 展示管理员理信息
     *
     * @param int $id
     */
    public function show(int $id = 0)
    {
        $info = $this->administratorService->show($id);

        echo json_encode($info);
    }

    /**
     * 创建管理员
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'uname'                 => 'required|min:3|max:18|unique:admin_users,uname',
            'password'              => 'required|min:5|max:18|confirmed',
            'password_confirmation' => 'required|min:5|max:18',
        ]);
        $uname      = $request->input('uname');
        $password   = $request->input('password');
        $repassword = $request->input('password_confirmation');
        if (strcasecmp($password, $repassword) != 0) {
            exit('fail');
        } else {
            $this->administratorService->register($uname, $password);
        }

        return view('admin.users.users');
    }

    /**
     * 删除管理员
     *
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $b  = $this->administratorService->delete($id);
        echo $b;
    }

    /**
     * 更新管理员信息
     *
     * @param array $data
     */
    public function edit(Request $request)
    {
        $this->validate($request, [
//            'id'                    => 'required',
//            'uname'                 =>'required|min:3|max:18|unique:admin_users,uname',
//            'email'                 =>'email|unique:admin_users',
//            'phone'                 =>'required|numeric|min:10|max:11',
'password'              => 'required|min:5|max:18|confirmed',
'password_confirmation' => 'required|min:5|max:18'
        ]);

        $id         = $request->input('id');
        $uname      = $request->input('uname');
        $email      = $request->input('email');
        $phone      = $request->input('phone');
        $password   = $request->input('password');
        $repassword = $request->input('password_confirmation');
        echo '<pre>';
        if (strcasecmp($password, $repassword) === 0) {
            $data = compact('id', 'uname', 'email', 'phone', 'password');
            $b    = $this->administratorService->edit($data);
        } else {
            $b = '密码不一致';
        }

        echo($b);
    }

    public function updatePassword()
    {
    }

}