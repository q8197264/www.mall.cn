<?php

namespace App\Models;

use App\User;
use Illuminate\Support\Facades\DB;
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Collection;

class UserModel
{
    protected $users      = 'users';
    protected $user_auths = 'user_auths';

    private $master;
    private $slave;

    public function __construct()
    {
        $this->master = DB::connection('mysql::write');
        $this->slave  = DB::connection('mysql::read');
    }

    /**
     * 动词add, update, del, query + 表名 + 条件
     * 可拆解query后By前字符做表映射，拆解By后字符映射DB表字段
     * @param $where    ['']
     *
     * @return mixed
     */
    public function queryUserByIndex(array $wheres)
    {
        $where  = '';
        foreach ($wheres as $k=>$v) {
            $where .= ' `'.$k.'`="'.$v.'" AND';
        }
        $where = trim($where, 'AND');
        $sql = <<<EOF
            SELECT `uid`,`grant_type`,`credential` FROM `{$this->user_auths}` WHERE {$where} 
EOF;
        $res = $this->slave->select($sql);

        return $res;
    }


    public function updateUserAt($id, array $data)
    {

    }
    
    //
    public function getUsers()
    {
        $res = User::where('id', 1)->get();
        foreach ($res as $v) {
//            $data[] = $v;
            echo json_encode($v);
            print_r($v);
        }

//        print_r($data);
        exit;
        $res = objectToArray($res);

        return $res;
    }

    public function queryUsersList(int $offset, int $limit)
    {
        echo $sql = <<<EOF
            SELECT
                *
            FROM
                `user_auths`
            WHERE `uid` IN (
                    SELECT
                        `id`
                    FROM
                        `users`
                    WHERE
                        `id` >= (
                            SELECT
                                `id`
                            FROM
                                `users`
                            ORDER BY
                                `id`
                            LIMIT ?,1
                        )
                )
            GROUP BY `id` 
            LIMIT ?
EOF;
        exit('--');
        $users = $this->slave->select($sql, [$offset, $limit]);

        return $users;
    }

    /**
     * 事务同时插入两个表
     *
     * @param array $data
     *
     * @return bool
     */
    public function insert(array $data)
    {
        DB::connection()->enableQueryLog();
        try {
            $b = DB::transaction(function () use ($data) {
                $uid = $this->master->table($this->users)
                    ->insertGetId([
                            'nickname'  =>'',
                            'created_at'=>date('Y-m-d H:i:s',time()),
                            'type'      =>0
                    ]);
                $b = $this->master->table($this->user_auths)
                    ->insertGetId([
                            'uid'          => $uid,
                            'grant_type'   => $data['grant_type'],
                            'identifier'   => $data['identifier'],
                            'credential'   => $data['credential'],
                            'created_at'   => date('Y-m-d H:i:s',time())
                    ]);
                return $b;
            }, 5);
        }catch(\Throwable $e) {
            $b = $e->getCode();
        }

        return $b;
    }


}
