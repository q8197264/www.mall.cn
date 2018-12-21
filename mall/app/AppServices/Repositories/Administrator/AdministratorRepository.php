<?php
namespace App\AppServices\Repositories\Administrator;

use App\AppServices\Models\AdministratorModel;
use App\AppServices\Repositories\AbstractRepository;

/**
 * Administrator Repository.
 *
 * User: liuxiaoquan
 * Date: 2018-12-06
 * Time: 12:25
 */
class AdministratorRepository extends AbstractRepository
{
    protected $administratorModel;
    protected static $type;

    public function __construct(AdministratorModel $administratorModel)
    {
        $this->administratorModel = $administratorModel;
    }

    /**
     * 查询管理员
     * Query Adiminstrator by factory
     *
     * @param string $uname
     *
     * @return array
     */
    public function queryAdministratorByFactory(string $uname):array
    {
        $user = self::checkUserType($uname);
        switch (key($user))
        {
            case 'phone':
                $user = $this->administratorModel->queryAdministratorByPhone(current($user));
                break;
            case 'username':
                $user = $this->administratorModel->queryAdministratorByName(current($user));
                break;
            case 'email':
                $user = $this->administratorModel->queryAdministratorByEmail(current($user));
                break;
            default:
        }

        return $user;
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
     * 添加管理员
     *
     * @param array $data
     *
     * @return bool|mixed
     */
    public function addAdministrator(string $uname, string $password)
    {
        $info = $this->administratorModel->queryAdministratorByName($uname);
        if (empty($info)) {
            $b = $this->administratorModel->addAdministrator($uname, $password);
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