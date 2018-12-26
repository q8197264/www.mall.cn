<?php

namespace App\AppServices\Models;

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

    public function queryUserByGrant(string $uname, string $grant_type):array
    {
        $sql = <<<EOF
            SELECT 
                `uid`,`grant_type`,`identifier`,`credential` ,`unbind` 
            FROM 
                `{$this->user_auths}` 
            WHERE 
                `identifier`=?  AND `grant_type`=? AND `unbind`=0
            LIMIT 1
EOF;
        //$this->slave->enableQueryLog();
        $res = $this->slave->select($sql, [$uname, $grant_type]);
        //$list = $this->slave->getQueryLog();
//        \Event::listen('illuminate.query', function($query){
//            dd($query);
//        });

        return empty($res)?[]: (array) array_shift($res);
    }

    /**
     * 动词add, update, del, query + 表名 + 条件
     * 可拆解query后By前字符做表映射，拆解By后字符映射DB表字段
     * @param $where    ['']
     *
     * @return mixed
     */
    public function queryUserByIndex(array $wheres):array
    {
        $where  = '';
        foreach ($wheres as $k=>$v) {
            $where .= ' u.`'.$k.'`=？ AND';
        }
        $where = trim($where, 'AND');
        $sql = <<<EOF
            SELECT
                a.`uid`,
                a.`grant_type`,
                a.`credential`,
                u.`nickname` 
            FROM
                `{$this->user_auths}` a
                INNER JOIN `{$this->users}` u ON a.`uid` = u.`id` 
            WHERE
                {$where}
                AND `unbind` = 0 
                LIMIT 1
EOF;
        $args = array_values($wheres);
        $res = $this->slave->select($sql, $args);
dd('test',$res);
        return (array) array_pop($res);
    }

    /**
     * Query user is exists
     *
     * @param array $data
     *
     * @return mixed
     */
    public function queryUserByMultiGrant(array $data):array
    {
        $where = [];
        $args = [];
        foreach ($data as $v) {
            $where[] = '(`grant_type` =? AND `identifier` =?)';
            $args[] = $v['grant_type'];
            $args[] = $v['identifier'];
        }
        $where = implode($where,' OR ');
        $sql = <<<EOF
            SELECT 
                `uid`,`grant_type`,`identifier`,`credential`,`unbind` 
            FROM 
                `{$this->user_auths}` 
            WHERE 
                {$where}
EOF;
        $res = $this->slave->select($sql, $args);

        return $res;
    }

    /**
     * update user info
     *
     * @param int   $uid
     * @param array $where
     *
     * @return bool
     */
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

    /**
     * show user list
     *
     * @param int $offset
     * @param int $limit
     *
     * @return mixed
     */
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
                                `{$this->users}`
                            ORDER BY
                                `id`
                            LIMIT ?,1
                        ) 
                        AND `state`=0
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
    public function insert(array $data):int
    {
        //$this->master->enableQueryLog();
        try {
            $uid = $this->master->transaction(function () use ($data) {
                //insert into users
                $uid = $this->master->table($this->users)
                    ->insertGetId([
                            'nickname'  =>'',
                            'created_at'=>date('Y-m-d H:i:s',time()),
                            'type'      =>0
                    ]);

                //insert into user_auths
                foreach ($data as $v) {
                    if ($v['grant_type'] != 'www') {
                        $v['credential']='';
                    }
                    $this->master->table($this->user_auths)
                        ->insertGetId([
                            'uid'          => $uid,
                            'grant_type'   => $v['grant_type'],
                            'identifier'   => $v['identifier'],
                            'credential'   => $v['credential'],
                            'created_at'   => date('Y-m-d H:i:s',time())
                        ]);
                }

                return $uid;
            }, 5);
        }catch(\Throwable $e) {
            $uid = 0;
        }
        //echo $this->master->getQueryLog();

        return $uid;
    }

    /**
     * soft delete
     *
     * @param int $uid
     *
     * @return bool
     */
    public function softDelete(int $uid):bool
    {
        $b=false;
        try{
            DB::transaction(function ()use ($uid) {
                $b=$this->master->table($this->users)
                    ->where(['id'=>$uid])
                    ->update(['state'=>1]);
                $b=$this->master->table($this->user_auths)
                    ->where(['uid'=>$uid])
                    ->update(['unbind'=>1]);
                return $b;
            }, 5);
        }catch(\Throwable $e){
            $b = $e->getCode();
        }

        return $b;
    }

}
