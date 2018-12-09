<?php
namespace App\Models;

use App\User;
use Illuminate\Support\Facades\DB;

/**
 * 系统模型.
 * User: liuxiaoquan
 * Date: 2018-12-06
 * Time: 12:29
 */
class AdministratorModel
{
    protected $table = 'admin_users';
    protected $master;
    protected $slave;

    public function __construct()
    {
        $this->master = DB::connection('mysql::write');
        $this->slave  = DB::connection('mysql::read');
    }

    public function queryAdministratorById(int $id):array
    {
        $sql = <<<EOF
            SELECT `id`,`uname`,`email`,`phone`,`password` FROM {$this->table} WHERE `id`=? LIMIT 1
EOF;
        $info = $this->slave->select($sql, [$id]);

        return (array) array_pop($info);
    }

    public function queryAdministratorByName(string $uname):array
    {
        $sql = <<<EOF
            SELECT `id`,`uname`,`email`,`phone`,`password` FROM `{$this->table}` WHERE `uname`=? LIMIT 1
EOF;
        $user = $this->slave->select($sql, [$uname]);

        return (array) array_pop($user);
    }

    public function queryAdministratorList(int $offset, int $limit)
    {
        $sql = <<<EOF
            SELECT
                `id`,
                `uname`,
                `email`,
                `phone`
            FROM
                `{$this->table}`
            WHERE
                `id` >= (
                    SELECT
                        `id`
                    FROM
                        `{$this->table}`
                    ORDER BY
                        `id`
                    LIMIT ?,1
                )
            LIMIT ?
EOF;
        $list = $this->slave->select($sql, [$offset, $limit]);

        return $list;
    }

    /**
     * 添加管理员
     *
     * @param array $data
     *
     * @return mixed
     */
    public function addAdministrator(array $data):bool
    {
        $sql = <<<EOF
            INSERT INTO `{$this->table}`(
                `uname`,
                `password`,
                `created_at`  
            ) VALUE
                (?,?,?)
EOF;

        $b = $this->master->insert($sql,
            [$data['uname'], $data['password'], date('Y-m-d H:i:s',time())]
        );
        return $b;
    }

    /**
     * 删除
     * @param int $id
     *
     * @return mixed
     */
    public function delAdministrator(int $id):bool
    {
        $sql = <<<EOF
            DELETE FROM `{$this->table}` WHERE `id`=?
EOF;
        $b = $this->master->delete($sql, [$id]);

        return $b;
    }

    /**
     * 更新
     *
     * @param array $data
     */
    public function editAdministrator(array $data):bool
    {
        $set = '';
        $res = [];
        $id  = '';
        foreach ($data as $k=>$v) {
            if ($k=='id') {
                $id = $v;
            } else {
                if (!empty($v)) {
                    $set .= " `{$k}` = ?,";
                    $res[] = $v;
                }
            }
        }
        if (!empty($id)) {
            $res[] = $id;
            $set   = trim($set, ',');
            $sql = <<<EOF
            UPDATE `{$this->table}` SET {$set} WHERE `id`=? LIMIT 1
EOF;
            $b = $this->master->update($sql, array_values($res));
        }

        return $b??false;
    }

}