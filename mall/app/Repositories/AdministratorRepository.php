<?php
namespace App\Repositories;

use App\Models\AdministratorModel;

/**
 * Created by PhpStorm.
 * User: liuxiaoquan
 * Date: 2018-12-06
 * Time: 12:25
 */
class AdministratorRepository
{
    protected $administratorModel;

    public function __construct(AdministratorModel $administratorModel)
    {
        $this->administratorModel = $administratorModel;
    }

    public function queryAdministratorList(int $offset, int $limit)
    {
        return $this->administratorModel->queryAdministratorList($offset, $limit);
    }

    /**
     * 查询管理员
     *
     * @param int $id
     *
     * @return array
     */
    public function queryAdministratorById(int $id)
    {
        $user = $this->administratorModel->queryAdministratorById($id);

        return $user;
    }

    /**
     * 查询管理员
     *
     * @param string $uname
     *
     * @return array
     */
    public function queryAdministratorByName(string $uname)
    {
        //1.查询管理员帐号
        //2.插入管理员帐号
        $user = $this->administratorModel->queryAdministratorByName($uname);

        return $user;
    }

    /**
     * 添加管理员
     *
     * @param array $data
     *
     * @return bool|mixed
     */
    public function addAdministrator(array $data)
    {
        $info = $this->administratorModel->queryAdministratorByName($data['uname']);
        if (empty($info)) {
            $b = $this->administratorModel->addAdministrator($data);
        }

        return $b??false;
    }

    /**
     * 删除管理员
     *
     * @param int $id
     *
     * @return bool
     */
    public function delAdministrator(int $id):bool
    {
        return $this->administratorModel->delAdministrator($id);
    }

    /**
     * 更新管理员
     *
     * @param array $data
     *
     * @return mixed
     */
    public function editAdministrator(array $data)
    {
        return $this->administratorModel->editAdministrator($data);
    }
}