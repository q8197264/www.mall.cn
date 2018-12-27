<?php
namespace App\AppServices\Services\Administrator;

/**
 * 后台用户接口.
 *
 * User: liuxiaoquan
 * Date: 2018-11-23
 * Time: 14:21
 */
class Admin extends AbstractAdministrator
{
    protected function initialize() {}

    public function getById(int $uid=0)
    {
        return static::getAdministratorRespository()->queryById($uid);
    }

    /**
     * check user login info
     *
     * @param string $uname
     *
     * @return array
     */
    public function getByIdentifier(string $uname): array
    {
        $user = $this->getAdministratorRespository()->queryByIdentifier($uname);

        return $user;
    }

    /**
     * 用户列表
     *
     * @param int $offset
     * @param int $limit
     *
     * @return mixed
     */
    public function getList(int $offset, int $limit)
    {
        $list = $this->getAdministratorRespository()->queryList($offset, $limit);

        return $list;
    }

    public function del(int $uid)
    {
        return $this->getAdministratorRespository()->del($uid);
    }
}