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
    }

    public function show(int $id)
    {
        echo 'show user list...';
        $info = $this->admin->show($id);
        return $info;
    }

    public function getUserList(int $offset, int $limit)
    {
        $list = $this->admin->getUserList($offset, $limit);

        return $list;
    }

    public function softDelete($uid)
    {
        return 'soft delete uid';
    }

    /**
     * 第一步：1.检测用户名，并指名用户类型
              2.发送验证方式（手机/邮箱）

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
        $res = $this->customer->checkUser($uname);

        return $res;
    }

    /**
     * 注册用户名
     *
     * 第一步：1.检测用户名，并指名用户类型
              2.发送验证方式（手机/邮箱）

     * 第二步：1.显示上一步的用户名
              2.密码
              3.密码确认
              4.手机/邮箱
              5.登陆名
     * 第三步：1.支付方式绑定
     */
    public function register(array $data)
    {
        $user = $this->customer->register($data);

        return $user;
    }


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