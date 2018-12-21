<?php
namespace App\AppServices\Services;

use App\AppServices\Services\Administrator\Admin;

/**
 * Administrator Service.
 *
 * User: liuxiaoquan
 * Date: 2018-12-06
 * Time: 11:55
 */
class AdministratorService
{
    protected $userRepository;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

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
     * 检测登陆
     *
     * @param string $uname
     * @param string $password
     *
     * @return int
     */
    public function checkLogin(string $uname, string $password)
    {
        $info = $this->admin->getAdministratorInfo($uname);
        if (empty($info['password'])) {
            $code = 1;//no exists
        } elseif ( password_verify($password, $info['password']) ) {
            $code = 0;//success
        } else {
            $code = 2;//password fail
        }

        return ['code'=>$code, 'uid'=>$info['id']??0, 'msg'=>''];
    }

    /**
     * get administrator list
     *
     * @param int $offset
     * @param int $limit
     *
     * @return mixed
     */
    public function list(int $offset, int $limit)
    {
        return $this->admin->queryAdministratorList($offset, $limit);
    }

    /**
     * 展示个人信息
     *
     * @param int $id
     *
     * @return mixed
     */
    public function show(int $id)
    {
        $info = $this->admin->queryAdministratorById($id);

        return $info;
    }

    /**
     * 添加管理员
     *
     * @param array $data
     *
     * @return bool|mixed
     */
    public function register(string $uname, string $password)
    {
        $password = $this->encrypt($password);
        var_dump($password);
        return $this->admin->addAdministrator($uname, $password);
    }

    /**
     * 删除管理员
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id):bool
    {
        return $this->admin->delAdministrator($id);
    }

    /**
     * 更新管理员
     *
     * @param array $data
     *
     * @return mixed
     */
    public function edit(array $data)
    {
        return $this->admin->editAdministrator($data);
    }
}