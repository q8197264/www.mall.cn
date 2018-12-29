<?php
namespace App\AppServices\Models;

use App\User;
use Illuminate\Support\Facades\DB;

use App\AppServices\Models\Common\Config;

/**
 * Order Model.
 * User: sai
 * Date: 2018-12-21
 * Time: 12:19
 */
class OrderModel extends Config
{
    /**
     * add order table and relate goods table
     *
     * @param array $order
     * @param array $goodsList
     *
     * @return int
     */
    public function addOrderAndRelateGoods(array $order, array $goodsList):int
    {
        $order_id = $this->master->transaction(function () use ($order, $goodsList) {
            $order_id = $this->master->table($this->order_info)
                ->insertGetId([
                'order_no'      => $order['order_sn'],
                'user_id'       => $order['user_id'],
                'address_id'    => $order['address_id'],
                'goods_count'   => $order['goods_count'],
                'trade_status'  => $order['trade_status'],
                'pay_id'        => $order['pay_id'],
                'shop_id'       => $order['shop_id'],
                'goods_amount'  => $order['goods_amount'],
                'shipping_fee'  => $order['shipping_fee'],
                'order_amount'  => $order['order_amount'],
                'shipping_name' => $order['shipping_name'],
                'remark'        => $order['remark'],
                'created_at'    => $order['created_at'],
                'updated_at'    => $order['updated_at'],
            ]);
            foreach ($goodsList as $goods) {
                $this->master->table($this->order_goods)
                    ->insert([
                    'order_id'   =>$order_id,
                    'order_no'   =>$order['order_sn'],
                    'spu_id'     => $goods['spu_id'],
                    'sku_id'     => $goods['sku_id'],
                    'shop_id'    => $goods['shop_id'],
                    'number'     => $goods['number'],
                    'sku_price'  => $goods['sku_price'],
                    'total_fee'  => $goods['total_fee'],
                    'images'     => $goods['images'],
                    'created_at' => $goods['created_at'],
                    'updated_at' => $goods['updated_at'],
                ]);

                //reduce goods_sku stock
                $this->master->table($this->goods_sku)
                    ->where('id','=',$goods['sku_id'])
                    ->decrement('stock', $goods['number']);
            }

            return $order_id;
        });

        return $order_id;
    }

    public function getListByUid()
    {}

    /**
     * query order relate goods list
     *
     * @param int $order_id
     *
     * @return mixed
     */
    public function queryGoodsByOrderId(int $order_id)
    {
        $sql = <<<EOF
            SELECT 
              g.`order_id`,
              g.`order_no`,
              g.`spu_id`,
              g.`sku_id`,
              g.`shop_id`,
              g.`number`,
              g.`sku_price`,
              g.`total_fee`,
              g.`images`,
              g.`created_at`,
              g.`updated_at`,
              k.`status`,
              p.`goods_name`,
              p.`spu_no`,
              p.`brand_id` 
            FROM 
              `{$this->order_goods}` g
              inner join `goods_sku` k on g.`sku_id`=k.`id` 
              inner join `goods_spu` p on k.`spu_id`=p.`id`
            WHERE 
              g.`order_id`=?
EOF;

        $rows = $this->slave->select($sql, [$order_id]);

        return $rows;
    }


    public function querySales(string $start, string $end)
    {
        $sql = <<<EOF
            SELECT
                o.`id`,
                o.`order_no`,
                k.`sku_name`,
                sum(g.`number`) as `number`   
            FROM
                `{$this->order_info}` o
                LEFT JOIN `{$this->order_goods}` g ON o.`id` = g.`order_id`
                INNER JOIN `{$this->goods_sku}` k ON g.`sku_id` = k.`id` 
            WHERE
                o.`created_at` BETWEEN ? AND ? GROUP BY g.sku_id
EOF;

        $rows = $this->slave->select($sql, [$start, $end]);

        return $rows;
    }
}