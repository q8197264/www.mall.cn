<?php
/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-19
 * Time: 10:49
 */

namespace App\AppServices\Models;

use App\User;
use Illuminate\Support\Facades\DB;

class CartModel
{
    protected $carts     = 'carts';
    protected $goods_sku = 'goods_sku';

    protected $master;
    protected $slave;

    public function __construct()
    {
        $this->master = DB::connection('mysql::write');
        $this->slave  = DB::connection('mysql::read');
    }

    /**
     * query cart list data with user
     *
     * @param int $uid
     *
     * @return mixed
     */
    public function getCartList(int $uid, bool $selected)
    {
        $sql = <<<EOF
            SELECT
                c.`id` `cart_id`,
                c.`spu_id`,
                c.`sku_id`,
                c.`shop_id`,
                c.`add_price`,
                c.`spu_numbers`,
                c.`status`,
                u.`sku_no`,
                u.`sku_name`,
                u.`price`,
                u.`stock`,
                u.`images` 
            FROM
                `{$this->carts}` c
                LEFT JOIN `{$this->goods_sku}` u ON c.`spu_id` = u.`spu_id` 
                AND c.`sku_id` = u.`id` 
                AND c.`shop_id` = u.`shop_id` 
            WHERE
                c.`user_id` = ? 
                AND c.`status` =0 
EOF;
        $sql .= $selected?' AND c.`selected`=1':'';
        $res = $this->slave->select($sql, [$uid, $selected]);

        return $res;
    }

    /**
     * query cart only on row with user and goods
     *
     * @param int $user_id
     * @param int $spu_id
     * @param int $sku_id
     * @param int $shop_id
     *
     * @return mixed
     */
    public function getById(int $user_id, int $spu_id, int $sku_id, int $shop_id) :array
    {
        $sql = <<<EOF
            SELECT
                `id` `cart_id`,
                `spu_numbers` 
            FROM
                `{$this->carts}` 
            WHERE
                `user_id` =? 
                AND `spu_id` =? 
                AND `sku_id` =? 
                AND `shop_id` =? 
                LIMIT 1
EOF;
        $row = $this->slave->select($sql, [$user_id, $spu_id, $sku_id, $shop_id]);

        return (array) array_pop($row);
    }

    /**
     * add row to cart
     *
     * @param int $user_id
     * @param int $spu_id
     * @param int $sku_id
     * @param int $shop_id
     * @param int $number
     *
     * @return bool
     */
    public function add(int $user_id, int $spu_id, int $sku_id, int $shop_id, int $number, $add_price): bool
    {
        $sql  = <<<EOF
            INSERT INTO `{$this->carts}` (
                `spu_id`,
                `sku_id`,
                `shop_id`,
                `user_id`,
                `spu_numbers`,
                `add_price`,
                `status`,
                `created_at`,
                `updated_at` 
            ) 
            VALUE
                ( ?,?,?,?,?,?,?,?,? )
EOF;
        $now  = date('Y-m-d H:i:s', time());
        $bool = $this->master->insert($sql, [$spu_id, $sku_id, $shop_id, $user_id, $number, $add_price, 0, $now, $now]);

        return $bool;
    }

    /**
     * 加库存
     *
     * @param int $id
     * @param int $number
     *
     * @return mixed
     */
    public function addStock(int $id, int $number)
    {
        $sql = <<<EOF
            UPDATE `{$this->carts}` 
            SET `spu_numbers` = `spu_numbers` +? 
            WHERE
                `id` =? 
                LIMIT 1
EOF;
        $bool = $this->master->update($sql, [$number, $id]);

        return $bool;
    }

    /**
     * update cart goods number
     *
     * @param int $id
     * @param int $number
     *
     * @return bool
     */
    public function updateCartGoodsNumber(int $id, int $number):bool
    {
        $sql = <<<EOF
            UPDATE `{$this->carts}` SET `spu_numbers`=? WHERE `id`=? LIMIT 1
EOF;
        $bool = $this->master->update($sql, [$number, $id]);

        return $bool;
    }

    /**
     * update cart goods
     *
     * @param int $cart_id
     * @param int $isChecked
     *
     * @return mixed
     */
    public function updateSelectedById(int $cart_id, bool $isChecked):bool
    {
        $sql = <<<EOF
            UPDATE `{$this->carts}` SET `selected`=? WHERE `id`=? LIMIT 1
EOF;
        $bool = $this->master->update($sql, [$isChecked, $cart_id]);

        return $bool;
    }
}