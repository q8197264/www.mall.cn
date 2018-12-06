<?php
namespace App\Services;

use App\Services\User\Customer;
use App\Services\User\Admin;

/**
 * 用户.
 * User: liuxiaoquan
 * Date: 2018-11-22
 * Time: 21:10
 */
class UserService
{
    protected $customer;
    protected $admin;

    public function __construct(Customer $customer, Admin $admin)
    {
        $this->customer = $customer;
        $this->admin    = $admin;
        
        date_default_timezone_set('PRC');
    }

    /**
     * 检测用户名
     *
     * @param $uname
     *
     * @return mixed
     */
    public function checkUser($uname)
    {
        //1.频率控制（重复请求丢弃） md5->redis setnx
        //2.验证参数
        //3.判断帐号类型
        //4.getUser
        $res = $this->admin->checkUser($uname);

        return $res;
    }

    public function createAdministrator(array $data)
    {
        $data['password'] = md5(bcrypt($data['password']));
        $user = $this->admin->createAdministrator($data);

        return $user;
    }

    /**
     * 后台创建用户
     *
     * @param array $info
     *
     * @return mixed
     */
    public function createUser(array $data)
    {
        //1. 判重
        //3. 判断帐号类型
        //4. 入库
        $data['password'] = md5(bcrypt($data['password']));
        $user = $this->admin->createUser($data);

        return $user;
    }

    /**
     * 注册用户名
     *
     * 第一步：1.检测用户名，并指名用户类型
              2.发送验证方式（手机/邮箱）

     * 第二步：1.显示用户名
              2.密码
              3.密码确认
              4.手机/邮箱
              5.登陆名
     * 第三步：1.支付方式绑定
     */
    public function register(){}



    /**
     * 展示个人信息
     *
     * @return \Generator
     */
    public function showUserInfo(int $id)
    {
        $all = $this->customer->show($id);
        foreach ($all as $v) {
            echo $v."\n";
        }
        
        return $all;
    }

    /**
     *
     */
    public function getUsersList()
    {
        $this->customer->getAllUsers();
    }


}