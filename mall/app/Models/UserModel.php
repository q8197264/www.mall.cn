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
            $where .= '`'.$k.'`="'.$v.'"';
        }
        $sql = <<<EOF
            SELECT `uid`,`identity_type`,`credential` FROM `{$this->user_auths}` WHERE {$where} 
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

    public function getAllUser()
    {
        $users = $this->slave->select('select * from users where id = ?', [1]);
        //        return $this->user->all();
        return $users;
    }

    /**
     * 同时插入两个表
     * 
     * @param array $data
     *
     * @return bool
     */
    public function insert(array $data)
    {
        echo '<pre>';print_r($data);

        $sql = <<<EOF
            INSERT INTO `{$this->users}`(
                ``,``,`` 
            )VALUE(?,?)
EOF;
        $sql2 = <<<EOF
            INSERT INTO `{$this->user_auths}`(
                `uid`,`identity_type`,`identifier`,`credential` 
            )VALUE(?,?,?,?)
EOF;
        $this->master->insertGetId($sql, [time()]);
        echo $sql, $sql2;
        exit('xx');
        try {
            DB::transaction(function ()use($sql, $sql2) {
                $data = $this->master->insert($sql, [time()]);
                $this->master->insert($sql2, [$data['uid'], '', '', '']);
            }, 5);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }

        return true;
    }


}
