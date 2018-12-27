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
    public function queryByIdentifier(string $uname):array
    {
        $user = self::checkUserType($uname);
        switch (key($user))
        {
            case 'phone':
                $user = $this->administratorModel->queryByPhone(current($user));
                break;
            case 'username':
                $user = $this->administratorModel->queryByName(current($user));
                break;
            case 'email':
                $user = $this->administratorModel->queryByEmail(current($user));
                break;
            default:
        }

        return $user;
    }

    public function queryList(int $offset, int $limit)
    {
        return $this->administratorModel->queryList($offset, $limit);
    }

    /**
     * 查询管理员
     *
     * @param int $id
     *
     * @return array
     */
    public function queryById(int $id)
    {
        $user = $this->administratorModel->queryById($id);

        return $user;
    }

    /**
     * 添加管理员
     *
     * @param array $data
     *
     * @return bool|mixed
     */
    public function add(string $uname, string $password)
    {
        $info = $this->administratorModel->queryByName($uname);
        if (empty($info)) {
            $b = $this->administratorModel->add($uname, $password);
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
    public function del(int $id):bool
    {
        return $this->administratorModel->delById($id);
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
        return $this->administratorModel->editById($data);
    }
}