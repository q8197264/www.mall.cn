<?php
namespace App\Services\User;

use App\Services\User;

/**
 * Created by PhpStorm.
 * User: liuxiaoquan
 * Date: 2018-11-23
 * Time: 14:24
 */
class Customer extends AbstractUser
{
    protected function initialize(){}

    public function show()
    {
        echo (__METHOD__)."\n";
        // TODO: Implement show() method.
        $users = static::getUserRespository()->getAllUsers();
        foreach($users as $user) {
            foreach ($user as $k=>$v) {
                yield json_encode(array($k=>$v));
            }
        }
    }

    public function getAllUsers()
    {
        $users = static::getUserRespository()->getAllUsers();
        foreach($users as $user) {
            print_r($user->uname);
        }
    }

    public function getUser()
    {
        $users = static::getUserRespository()->getUser();
        return $users;
    }
}