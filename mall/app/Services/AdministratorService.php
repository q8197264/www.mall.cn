<?php
namespace App\Services;

use App\Repositories\AdministratorRepository;
use Illuminate\Support\Facades\Request;

/**
 * Created by PhpStorm.
 * User: liuxiaoquan
 * Date: 2018-12-06
 * Time: 11:55
 */
class AdministratorService
{
    protected $userRepository;

    public function __construct(AdministratorRepository $administratorRepository)
    {
        $this->administratorRepository = $administratorRepository;
    }

    /**
     * 登陆密码加密
     *
     * @param string $pwd
     *
     * @return mixed
     */
    protected function encrypt(string $pwd)
    {
        return md5(bcrypt($pwd));
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
        $info = $this->administratorRepository->queryAdministratorByName($uname);
        $password = $this->encrypt($password);
        if (empty($info['password'])) {
            $b = 1;
        } elseif (strcasecmp($password, $info['password']) != 0) {
            $b = 0;
        } else {
            $b = 2;
        }

        return $b;
    }

    public function listing(int $offset, int $limit)
    {
        return $this->administratorRepository->queryAdministratorList($offset, $limit);
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
        $info = $this->administratorRepository->queryAdministratorById($id);

        return $info;
    }

    /**
     * 添加管理员
     *
     * @param array $data
     *
     * @return bool|mixed
     */
    public function add(array $data)
    {
        $data['password'] = $this->encrypt($data['password']);
        return $this->administratorRepository->addAdministrator($data);
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
        return $this->administratorRepository->delAdministrator($id);
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
        return $this->administratorRepository->editAdministrator($data);
    }
}