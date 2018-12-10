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
        'user'     => 'identifier',
        'password' => 'credential',
        'www'      => 'grant_type'//www email phone uname
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
            return $res;
        }

        //自动检测帐户类型：并从DB读取对应用户
        $user = self::checkUserName($data['user']);
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
    public function register(array $data)
    {
        $uid = '';
        $data = $this->mapFields($data);
        $user = $this->queryUserByName($data['identifier'], $data['grant_type']);
        if (empty($user)) {
            $uid = $this->userModel->insert($data);
        }

        return $uid;
    }

    public function getUser()
    {
        return $this->userModel->getUsers();
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
     * 动词add, update, del, query + 表名 + 条件
     * 可拆解query后By前字符做表映射，拆解By后字符映射DB表字段
     * @param $uname
     *
     * @return mixed
     */
    public function queryUserByName(string $uname, string $grant_type='')
    {
        $where = $this->mapFields(['identifier' => $uname, 'grant_type'=>$grant_type]);

        return $this->userModel->queryUserByIndex($where);
    }

    /**
     *
     *
     * @param int $id
     *
     * @return mixed
     */
    public function queryUserById(int $id)
    {
        return $this->userModel->queryUserByIndex(['id'=>$id]);
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