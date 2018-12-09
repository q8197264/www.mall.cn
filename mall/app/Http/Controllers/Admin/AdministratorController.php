<?php
namespace App\Http\Controllers\Admin;

use App\Services\AdministratorService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 系统管理员模块.
 *
   1. 登陆
   2. 注册
   3. 管理员信息
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
    public function login()
    {
        echo 'admin login...';
        return view('admin.administrator');
    }

    /**
     * 展示列表
     *
     * @param int $offset
     * @param int $limit
     */
    public function listing(int $offset, int $limit)
    {
        $list = $this->administratorService->listing($offset, $limit);
        echo '<pre>';print_r($list);
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
        $b = $this->administratorService->checkLogin($uname, $password);
        switch ($b) {
            case 0:
                $b = 'success';
                break;
            case 1:
                $b = 'non data';
                break;
            case 2:
                $b = 'fail';
                break;
        }

        echo $b;
    }

    /**
     * 展示管理员理信息
     *
     * @param int $id
     */
    public function show(int $id)
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

        $this->administratorService->add($data);

        return view('admin.users.add');
    }

    /**
     * 删除管理员
     *
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $b = $this->administratorService->delete($id);
        echo $b;
    }

    /**
     * 更新管理员信息
     *
     * @param array $data
     */
    public function edit(Request $request)
    {
        $this->validate($request,[
//            'id'                    => 'required',
//            'uname'                 =>'required|min:3|max:18|unique:admin_users,uname',
//            'email'                 =>'email|unique:admin_users',
//            'phone'                 =>'required|numeric|min:10|max:11',
            'password'              =>'required|min:5|max:18|confirmed',
            'password_confirmation' =>'required|min:5|max:18'
        ]);

        $id         = $request->input('id');
        $uname      = $request->input('uname');
        $email      = $request->input('email');
        $phone      = $request->input('phone');
        $password   = $request->input('password');
        $repassword = $request->input('password_confirmation');
        echo '<pre>';
        if (strcasecmp($password, $repassword) === 0) {
            $data = compact('id','uname','email','phone','password');
            $b = $this->administratorService->edit($data);
        } else {
            $b = '密码不一致';
        }

        echo ($b);
    }

    public function updatePassword()
    {}
    
}