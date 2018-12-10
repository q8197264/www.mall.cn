<?php
namespace App\Services\User;

use App\Services\User;

/**
 * 消息者.
 * User: liuxiaoquan
 * Date: 2018-11-23
 * Time: 14:24
 */
class Customer extends AbstractUser
{
    protected function initialize(){}

    public function show()
    {
        $users = static::getUserRespository()->getAllUsers();
        foreach($users as $user) {
            foreach ($user as $k=>$v) {
                yield json_encode(array($k=>$v));
            }
        }
    }

    /**
     * 用户注册
     *
     * @param array $data
     *
     * @return mixed
     */
    public function register(array $data)
    {
        $data['password'] = md5(bcrypt($data['password']));

        return $this->getUserRespository()->register($data);
    }

    /**
     *
     * @return mixed
     */
    public function getUser()
    {
        $users = static::getUserRespository()->getUser();
        return $users;
    }

    public function edit(int $uid, array $where)
    {
        return static::getUserRespository()->updateUserById($uid, $where);
    }
}