<?php
namespace App\Models;

use App\User;
use Illuminate\Support\Facades\DB;

/**
 * 类目数据模型.
 * User: liuxiaoquan
 * Date: 2018-12-03
 * Time: 11:53
 */
class AdminCategoryModel
{
    protected $table= 'admin_categories';

    //查询分类导航
    public function queryAdminCategory()
    {
        $sql = <<<EOF
            SELECT
                `cid`,
                `pid`,
                `cname`,
                `status`
            FROM
                `admin_categories`
            ORDER BY
                `id`
            WHERE 
                `status`= 0
EOF;
        $res = DB::connection('mysql::read')->select($sql);

        return $res;
    }

    //存在分类导航
    public function existsCategory(int $pid, string $cname)
    {
        $sql = <<<EOF
            SELECT 
                `cid`,
                `pid`,
                `cname`,
                `status` 
            FROM `{$this->table}` 
            WHERE 
                `pid`=? 
                AND 
                `cname`=? 
EOF;
        $res = DB::connection('mysql::read')->select($sql, [$pid, $cname]);

        return $res;
    }

    //添加导航分类
    public function addAdminCategory(int $pid, string $cname)
    {
        $sql = <<<EOF
            INSERT INTO `{$this->table}`(
                `cid`,`pid`,`cname`
            ) SELECT 
                    MAX(`cid`)+1, ?, ? 
                FROM `{$this->table}`
EOF;
        $b = DB::connection('mysql::write')->insert($sql, [$pid, $cname]);

        return $b;
    }

    //更新分类导航栏
    public function updateAdminCategory(int $cid, string $cname)
    {
        $sql = <<<EOF
            UPDATE `{$this->table}` SET `cname`=?,`status`=0 WHERE `cid`=? LIMIT 1
EOF;
        $b = DB::connection('mysql::write')->update($sql, [$cname, $cid]);

        return $b;
    }

    //删除分类导航栏
    public function delAdminCategory(int $cid)
    {
        echo $sql = <<<EOF
            DELETE FROM {$this->table} WHERE `cid`=? LIMIT 1
EOF;
        $b = DB::connection('mysql::write')->delete($sql, [$cid]);

        return $b;
    }
}