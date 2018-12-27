<?php
namespace App\AppServices\Models;

use App\User;
use Illuminate\Support\Facades\DB;

/**
 * Administrator model.
 *
 * User: liuxiaoquan
 * Date: 2018-12-06
 * Time: 12:29
 */
class AdministratorModel
{
    protected $admins = 'admins';

    protected $master;
    protected $slave;

    public function __construct()
    {
        $this->master = DB::connection('mysql::write');
        $this->slave  = DB::connection('mysql::read');
    }

    /**
     * Query for specified administrator information by id
     *
     * @param int $id
     *
     * @return array
     */
    public function queryById(int $id):array
    {
        $sql = <<<EOF
            SELECT 
                `id`,`uname`,`email`,`phone`,`password`,`remember_token` 
            FROM {$this->admins} 
            WHERE 
                `id`=? 
            LIMIT 1
EOF;
        $info = $this->slave->select($sql, [$id]);

        return (array) array_pop($info);
    }

    /**
     * Query for specified administrator information by username
     *
     * @param string $uname
     *
     * @return array
     */
    public function queryByName(string $uname):array
    {
        $sql = <<<EOF
            SELECT 
                `id`,`uname`,`email`,`phone`,`password`,`remember_token` 
            FROM `{$this->admins}` 
            WHERE 
                `uname`=? 
            LIMIT 1
EOF;
        $user = $this->slave->select($sql, [$uname]);

        return (array) array_pop($user);
    }

    /**
     * Query for specified administrator information by email
     *
     * @param string $email
     *
     * @return array
     */
    public function queryByEmail(string $email):array
    {
        $sql = <<<EOF
            SELECT 
                `id`,`uname`,`email`,`phone`,`password`,`remember_token` 
            FROM `{$this->admins}` 
            WHERE 
                `email`=? 
            LIMIT 1
EOF;
        $user = $this->slave->select($sql, [$email]);

        return (array) array_pop($user);
    }

    /**
     * Query for specified administrator information by phone
     *
     * @param int $phone
     *
     * @return array
     */
    public function queryByPhone(int $phone):array
    {
        $sql = <<<EOF
            SELECT 
                `id`,`uname`,`email`,`phone`,`password`,`remember_token` 
            FROM `{$this->admins}` 
            WHERE 
                `phone`=? 
            LIMIT 1
EOF;
        $user = $this->slave->select($sql, [$phone]);

        return  (array) array_pop($user);
    }

    /**
     * Query administrator info with list
     *
     * @param int $offset
     * @param int $limit
     *
     * @return array
     */
    public function queryList(int $offset, int $limit):array
    {
        $sql = <<<EOF
            SELECT
                `id`,`uname`,`email`,`phone` 
            FROM
                `{$this->admins}`
            WHERE
                `id` >= (
                    SELECT
                        `id`
                    FROM
                        `{$this->admins}`
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
    public function add(string $uname, string $password):bool
    {
        $sql = <<<EOF
            INSERT INTO `{$this->admins}`(
                `uname`,
                `password`,
                `created_at`  
            ) VALUE
                (?,?,?)
EOF;

        $b = $this->master->insert($sql,
            [$uname, $password, date('Y-m-d H:i:s',time())]
        );
        return $b;
    }

    /**
     * 删除
     * @param int $id
     *
     * @return mixed
     */
    public function delById(int $id):bool
    {
        $sql = <<<EOF
            DELETE FROM `{$this->admins}` WHERE `id`=?
EOF;
        $b = $this->master->delete($sql, [$id]);

        return $b;
    }

    /**
     * 更新
     *
     * @param array $data
     */
    public function editById(array $data):bool
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
            UPDATE `{$this->admins}` SET {$set} WHERE `id`=? LIMIT 1
EOF;
            $b = $this->master->update($sql, array_values($res));
        }

        return $b??false;
    }

}