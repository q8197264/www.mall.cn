<?php
namespace App\AppServices\Services\User;

use \Exception;

/**
 * 消息者.
 * User: liuxiaoquan
 * Date: 2018-11-23
 * Time: 14:24
 */
class Customer extends AbstractUser
{
    protected function initialize(){}

    /**
     * 登陆密码加密
     *
     * @param string $pwd
     *
     * @return mixed
     */
    protected function encrypt(string $password):string
    {
        $options = [
            //'salt' => custom_function_for_salt(), //自定义函数来获得盐值
            'cost' => 12 // the default cost is 10
        ];
        return password_hash(trim($password), PASSWORD_DEFAULT, $options);
    }

    /**
     * get user info (photo|address)
     *
     * @return \Generator
     */
    public function show(int $uid=0)
    {
        $user = static::getUserRespository()->getAllUsers();

        return $user;
    }

    /**
     * 用户注册
     *
     * @param array $data
     *
     * @return mixed
     */
    public function register(array $data):int
    {
        if (isset($data['grant_type']) && $data['grant_type']=='www') {
            $data['password'] = $this->encrypt($data['password']);
        }
        $uid = $this->getUserRespository()->register($data);

        return $uid;
    }

    /**
     * 编辑
     *
     * @param int   $uid
     * @param array $where
     *
     * @return mixed
     */
    public function edit(int $uid, array $where)
    {
        return static::getUserRespository()->updateUserById($uid, $where);
    }

    /**
     * 查询用户名
     *
     * @param string $uname/$openid
     *
     * @return mixed
     */
    public function checkLogin(string $grant_type, string $uname, string $password)
    {
        $info = static::getUserRespository()->queryUserByFactory($uname, $grant_type);
        if (empty($info)) {
            return [];
        }

        if (in_array($info['grant_type'], ['phone','email','username'])) {
            if ( !password_verify($password, $info['credential']) ) {
                throw new Exception('password fail');
            }
        }

        return $info;
    }


}