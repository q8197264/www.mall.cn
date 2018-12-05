<?php
namespace App\Repositories;

use App\Models\UserModel;

/**
 * 用户model.
 * User: liuxiaoquan
 * Date: 2018-11-22
 * Time: 20:54
 */
class UserRepository extends AbstractRepository
{
    /** @var User 注入的User model */
    protected $user;
    protected $userModel;

    protected static $map = [
        'uname'     => 'identifier',
        'password'  => 'credential',
        'app_type'   => 'identifier_type'
    ];

    public function __construct(UserModel $userModel)
    {
//        $this->user = $user;
        $this->userModel = $userModel;
//        $user = User::find(1);
//        return response()->json($user);
    }

    protected function mapFields(array $data)
    {
        $res = [];
        foreach ($data as $k=>$v) {
            if (isset(self::$map[$k])) {
                $res[self::$map[$k]] = $v;
            } else {
                $res[$k] = $v;
            }
        }
//        echo '<pre>';print_r($res);
//        print_r(array_flip(self::$map));
        $res = array_intersect_key($res, array_flip(self::$map));
//        print_r($res);

        return $res;
    }

    public function createUser(array $data)
    {
        $data = $this->mapFields($data);
        $user = $this->queryUserByName($data['identifier']);
        if (empty($user)) {
            $b = $this->userModel->insert($data);
        }
        exit('test');

        return $b;
    }

    public function getUser()
    {
        return $this->userModel->getUsers();
    }

    /**
     * @return Collection|User[]
     */
    public function getAllUsers()
    {
        return $this->userModel->getAllUser();
    }

    /**
     * 动词add, update, del, query + 表名 + 条件
     * 可拆解query后By前字符做表映射，拆解By后字符映射DB表字段
     * @param $uname
     *
     * @return mixed
     */
    public function queryUserByName($uname)
    {
        $data = $this->mapFields(['uname' => $uname]);

        return $this->userModel->queryUserByIndex($data);
    }

    public function queryUserById($id)
    {
        return $this->userModel->queryUserByIndex(['id'=>$id]);
    }
}