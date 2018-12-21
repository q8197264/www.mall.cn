<?php
namespace App\AppServices\Models;

use App\User;
use Illuminate\Support\Facades\DB;

/**
 * address model.
 *
 * User: sai
 * Date: 2018-12-19
 * Time: 22:14
 */
class AddressModel
{
    protected $address = 'address';

    protected $master;
    protected $slave;

    public function __construct()
    {
        $this->master = DB::connection('mysql::write');
        $this->slave  = DB::connection('mysql::read');
    }

    /**
     * get address list by uid
     *
     * @param int $uid
     * @param int $offset
     * @param int $limit
     *
     * @return mixed
     */
    public function getListByUid(int $uid, int $limit)
    {
        $sql = <<<EOF
            SELECT
                `id`,
                `user_id`,
                `name`,
                `tel`,
                `phone`,
                `address`,
                `zipcode`,
                `selected` 
            FROM
                `{$this->address}` 
            WHERE
                `user_id` =? 
                LIMIT ?
EOF;
        $res = $this->slave->select($sql, [$uid, $limit]);

        return $res;
    }

    /**
     * get address only one by user_id
     * @param int $uid
     *
     * @return mixed
     */
    public function getDefaultByUid(int $uid)
    {
        $sql = <<<EOF
            SELECT
                `id`,
                `user_id`,
                `name`,
                `tel`,
                `phone`,
                `address`,
                `zipcode`,
                `selected`
            FROM
                `{$this->address}` 
            WHERE
                `user_id` =? 
                AND `selected` = 1 
                LIMIT 1
EOF;
        $row = $this->slave->select($sql, [$uid]);

        return $row;
    }

    /**
     * update address of default selected
     *
     * @param int $id
     * @param int $uid
     *
     * @return mixed
     */
    public function updateDefaultById(int $id, int $uid):bool
    {
        $sql = <<<EOF
            UPDATE 
                `{$this->address}` 
            SET `selected` = IF ( `id` = ?, 1, 0 ) 
            WHERE
                `user_id` =?
EOF;
        $bool = $this->master->update($sql, [$id, $uid]);

        return $bool;
    }

    /**
     * add address row data to address
     *
     * @param string $username
     * @param int    $user_id
     *
     * @return mixed
     */
    public function add(array $parameters): int
    {
        $id = $this->master->table($this->address)->insertGetId([
            'user_id'=>$parameters['user_id'],
            'name'=>$parameters['name'],
            'tel'=>$parameters['name'],
            'phone'=>$parameters['phone'],
            'province'=>$parameters['province'],
            'city'=>$parameters['city'],
            'district'=>$parameters['district'],
            'address'=>$parameters['address']
        ]);

        return $id;
    }

    /**
     * Delete address by id and user_id
     *
     * @param int $id
     * @param int $uid
     *
     * @return bool
     */
    public function delById(int $id, int $uid):bool
    {
        $sql = <<<EOF
            DELETE * FROM `{$this->address}` WHERE `id`=? AND `user_id`=? LIMIT 1
EOF;
        $bool = $this->master->delete($sql, [$id, $uid]);

        return $bool;
    }
}