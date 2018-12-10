<?php
namespace App\Services\User;

use App\Services\User;

/**
 * 后台用户接口.
 * User: liuxiaoquan
 * Date: 2018-11-23
 * Time: 14:21
 */
class Admin extends AbstractUser
{
    protected function initialize() {}

    public function queryUserById(int $uid)
    {
        return static::getUserRespository()->queryUserById(['uid'=>$uid]);
    }

    public function show(int $uid)
    {
        return static::show($uid);
    }

    /**
     * 用户列表
     *
     * @param int $offset
     * @param int $limit
     *
     * @return mixed
     */
    public function getUserList(int $offset, int $limit)
    {
        $list = $this->getUserRespository()->queryUsersList($offset, $limit);

        return $list;
    }

    public function softDelete(int $uid)
    {
        return $this->getUserRespository()->softDelete($uid);
    }
}