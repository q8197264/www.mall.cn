<?php
namespace App\AppServices\Repositories\User;

use App\AppServices\Models\UserModel;
use App\AppServices\Repositories\AbstractRepository;

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
        'user'     => 'identifier',
        'password' => 'credential',
        'www'      => 'grant_type',//www email phone uname
    ];

    public function __construct(UserModel $userModel)
    {
//        $this->user = $user;
        $this->userModel = $userModel;
//        $user = User::find(1);
//        return response()->json($user);
    }

    /**
     * 字段映射
     *
    [
      ['username'=>'','password'
      ],[],[]
    ]
     *
     * @param array $data
     *
     * @return array
     */
    protected function mapFields(array $data):array
    {
        $res = [];

        //拆解同一用户不同登陆帐号：分别写入DB
        $data = array_filter($data);
        if (empty($data['user'])) {
            $fill = array_diff_key($data, array_flip(['username','phone','email']));
            foreach (['username','phone','email'] as $v) {
                if (isset($data[$v])) {
                    $res[$v] = array_merge($fill, array('user'=>$data[$v]));
                    $res[$v] = $this->mapFields($res[$v]);
                }
            }

            if (empty($res)) {
                $res[]=$fill;
            }
            return $res;
        }

        //自动检测帐户类型：并从DB读取对应用户
        $user = self::checkUserType($data['user']);
        $data['grant_type'] = $data['grant_type']??'www';
        if ($data['grant_type'] === 'www') {
            $data['grant_type'] = key($user);
        }

        $data['user']     = current($user);
        foreach ($data as $k=>$v) {
            if (isset(self::$map[$k])) {
                $res[self::$map[$k]] = $v;
            } else {
                $res[$k] = $v;
            }
        }
//        $res = array_intersect_key($res, array_flip(self::$map));

        return $res;
    }

    /**
     * 注册用户
     *
     * @param array $data
     *
     * @return bool|string
     */
    public function register(array $data):int
    {
        $uid = 0;
        $data = $this->mapFields($data);
        $user = $this->checkUserExists($data);

        //username or email 任有一种存在就不能注册
        if (empty($user)) {
            $uid = $this->userModel->insert($data);
        }

        return $uid;
    }

    /**
     * check user is exists
     *
     * @param array $data
     *
     * @return array
     */
    public function checkUserExists(array $data): array
    {
        $exists = $this->userModel->queryUserByMultiGrant($data);

        return $exists;
    }


    /**
     * 查询用户列表
     *
     * @return Collection|User[]
     */
    public function queryUsersList(int $offset, int $limit)
    {
        return $this->userModel->queryUsersList($offset, $limit);
    }

    /**
     * Query user info by `grant_type`(帐户类型) and `identifier`(用户标识)
     *
     * @param string $uname/openid
     * @param string $grant_type
     *
     * @return array
     */
    public function queryUserByFactory(string $uname, string $grant_type='www'):array
    {
        $user = $grant_type==='www'?self::checkUserType($uname):array($grant_type=>$uname);
        $user = $this->userModel->queryUserByGrant($uname, key($user));

        return $user;
    }

    /**
     * 动词add, update, del, query + 表名 + 条件
     * 可拆解query后By前字符做表映射，拆解By后字符映射DB表字段
     * @param $uname
     *
     * @return mixed
     */
    public function queryUserByName(string $uname, string $grant_type=''):array
    {
        $where = $this->mapFields(['user' => $uname, 'grant_type'=>$grant_type]);

        return $this->userModel->queryUserByIndex($where);
    }

    /**
     * Query user info by `user_id`(用户id)
     *
     * @param int $id
     *
     * @return mixed
     */
    public function queryUserById(int $uid=0)
    {
        return $this->userModel->queryUserByIndex(['id'=>$uid]);
    }

    /**
     * 编辑或添加用户帐号
     *
     * @param int   $uid
     * @param array $where
     */
    public function updateUserById(int $uid, array $where)
    {
        $where = $this->mapFields($where);

        //每种帐号一row记录
        foreach ($where as $v) {
            $b = $this->userModel->updateUserAt($uid, $v);
        }

        return $b;
    }

    public function softDelete(int $uid)
    {
        return $this->userModel->softDelete($uid);
    }
}