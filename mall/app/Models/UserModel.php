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


    public function updateUserAt(int $uid, array $where) :bool
    {
        //使用先select 后update or insert
        $sql = <<<EOF
            REPLACE INTO `{$this->user_auths}` (
                `uid`,
                `grant_type`,
                `identifier`,
                `credential`,
                `created_at`
            ) VALUE (
                ?,?,?,?,?
            )
EOF;
        $b = $this->master->insert($sql, [
            $uid,
            $where['grant_type'],
            $where['identifier'],
            $where['credential'],
            date('Y-m-d H:i:s', time())
        ]);

        return $b;
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
        $sql = <<<EOF
            SELECT
                `id`,`uid`,`grant_type`,`identifier`,`credential`,`created_at` 
            FROM
                `{$this->user_auths}`
            WHERE `uid` IN (
                    SELECT
                        `id`
                    FROM
                        `{$this->users}`
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
                        AND `off`=0
                ) AND `unbind`=0 
            GROUP BY `uid` 
            LIMIT ?
EOF;
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
//        DB::connection()->enableQueryLog();
        $this->b=false;
        try {
            $this->b = DB::transaction(function () use ($data) {
                $uid = $this->master->table($this->users)
                    ->insertGetId([
                            'nickname'  =>'',
                            'created_at'=>date('Y-m-d H:i:s',time()),
                            'type'      =>0
                    ]);
            $this->b = $this->master->table($this->user_auths)
                ->insertGetId([
                        'uid'          => $uid,
                        'grant_type'   => $data['grant_type'],
                        'identifier'   => $data['identifier'],
                        'credential'   => $data['credential'],
                        'created_at'   => date('Y-m-d H:i:s',time())
                ]);
            }, 5);
        }catch(\Throwable $e) {
            $this->b = $e->getCode();
        }

        return $this->b;
    }

    public function softDelete(int $uid):bool
    {
        $this->b=false;
        try{
            DB::transaction(function ()use ($uid) {
                $this->b=$this->master->table($this->users)
                    ->where(['id'=>$uid])
                    ->update(['off'=>1]);
                $this->b=$this->master->table($this->user_auths)
                    ->where(['uid'=>$uid])
                    ->update(['unbind'=>1]);
            }, 5);
        }catch(\Throwable $e){
            $this->b = $e->getCode();
        }
        return $this->b;
    }

}
