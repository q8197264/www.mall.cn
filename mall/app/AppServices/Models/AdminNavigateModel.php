<?php

namespace App\AppServices\Models;

use App\User;
use Illuminate\Support\Facades\DB;

/**
 * 类目数据模型.
 * User: liuxiaoquan
 * Date: 2018-12-03
 * Time: 11:53
 */
class AdminNavigateModel
{
    protected $master;
    protected $slave;

    protected $admin_navigates = 'admin_navigates';

    public function __construct()
    {
        $this->master = DB::connection('mysql::write');
        $this->slave  = DB::connection('mysql::read');
    }

    //查询分类导航
    public function query()
    {
        $sql = <<<EOF
            SELECT
                `cid`,
                `pid`,
                `cname`,
                `status`
            FROM
                `{$this->admin_navigates}`
            WHERE 
                `status`= 0
            ORDER BY
                `id`
            
EOF;
        $res = $this->slave->select($sql);

        return $res;
    }

    //存在分类导航
    public function exists(int $pid, string $cname)
    {
        $sql = <<<EOF
            SELECT 
                `cid`,
                `pid`,
                `cname`,
                `status` 
            FROM `{$this->admin_navigates}` 
            WHERE 
                `pid`=? 
                AND 
                `cname`=? 
EOF;
        $res = $this->slave->select($sql, [$pid, $cname]);

        return $res;
    }

    //添加导航分类
    public function add(int $pid, string $cname)
    {
        $sql = <<<EOF
            INSERT INTO `{$this->admin_navigates}`(
                `cid`,`pid`,`cname`
            ) SELECT 
                    MAX(`cid`)+1, ?, ? 
                FROM `{$this->admin_navigates}`
EOF;
        $b = $this->master->insert($sql, [$pid, $cname]);

        return $b;
    }

    //更新分类导航栏
    public function edit(int $cid, string $cname)
    {
        $sql = <<<EOF
            UPDATE `{$this->admin_navigates}` SET `cname`=?,`status`=0 WHERE `cid`=? LIMIT 1
EOF;
        $b = $this->master->update($sql, [$cname, $cid]);

        return $b;
    }

    //删除分类导航栏
    public function del(int $cid)
    {
        $sql = <<<EOF
            DELETE FROM {$this->admin_navigates} WHERE `cid`=? LIMIT 1
EOF;
        $b = $this->master->delete($sql, [$cid]);

        return $b;
    }
}