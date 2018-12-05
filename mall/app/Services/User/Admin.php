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

    public function show()
    {
        // TODO: Implement show() method.
        echo 'I am admin->model';
    }

}