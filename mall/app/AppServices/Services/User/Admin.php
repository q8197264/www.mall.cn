<?php
namespace App\AppServices\Services\User;

/**
 * 后台用户接口.
 *
 * User: liuxiaoquan
 * Date: 2018-11-23
 * Time: 14:21
 */
class Admin extends AbstractUser
{
    protected function initialize() {}

    public function show(int $uid=0)
    {
        return static::getUserRespository()->queryUserById($uid);
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

    /**
     * @param int $uid
     *
     * @return mixed
     */
    public function softDelete(int $uid)
    {
        return $this->getUserRespository()->softDelete($uid);
    }
}