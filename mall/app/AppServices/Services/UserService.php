<?php
namespace App\AppServices\Services;

use App\AppServices\Services\User\Customer;
use App\AppServices\Services\User\Admin;

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

    /**
     * UserService constructor.
     *
     * @param Customer $customer
     * @param Admin    $admin
     */
    public function __construct(Customer $customer, Admin $admin)
    {
        $this->customer = $customer;
        $this->admin    = $admin;
    }

    /**
     * 展示个人信息
     *
     * @param int $id
     *
     * @return mixed
     */
    public function show(int $id=0)
    {
        $info = $this->admin->show($id);

        return $info;
    }

    /**
     * get user list
     *
     * @param int $offset
     * @param int $limit
     *
     * @return mixed
     */
    public function list(int $offset, int $limit)
    {
        $list = $this->admin->getUserList($offset, $limit);

        return $list;
    }

    /**
     * soft delete user
     *
     * @param int $uid
     *
     * @return mixed
     */
    public function softDelete(int $uid)
    {
        return $this->admin->softDelete($uid);
    }

    /**
     * 第一步：1.检测用户名，并指名用户类型
              2.发送验证方式（手机/邮箱）

     * @param $user
     *
     * @return mixed
     */
    public function checkLogin(string $user, string $password, string $grant_type=''):array
    {
        $grant_type = empty($grant_type) ? 'www' : $grant_type;
        //1.频率控制（重复请求丢弃） md5->redis setnx
        //2.验证参数
        //3.判断帐号类型
        //4.getUser
        try{
            $res = $this->customer->checkLogin($grant_type, $user, $password);
            $res['code'] = empty($res)?1:0;
        }catch(\Exception $e){
            $res['code'] = 2;
            $res['msg'] = $e->getMessage();
        }

        return $res;
    }


    public function otherUserRegister()
    {

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
    public function register(array $data):int
    {
        $uid = $this->customer->register($data);

        return $uid;
    }

    /**
     *  编缉用户
     *
     * @param int   $uid
     * @param array $where
     *
     * @return mixed
     */
    public function edit(int $uid, array $where)
    {
        return $this->customer->edit($uid, $where);
    }

}