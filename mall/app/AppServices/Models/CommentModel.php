<?php
/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-24
 * Time: 00:14
 */

namespace App\AppServices\Models;

use App\AppServices\Models\Common\Config;

class CommentModel extends Config
{
    public function add()
    {
        $sql = <<<EOF
            insert into ``()value()
EOF;
        dd($sql);
    }

    /**
     * query goods are commented
     *
     * @param int $order_id
     *
     * @return mixed
     */
    public function queryGoodsWithCommented(int $order_id)
    {
        $sql  = <<<EOF
            select 
              `order_id`,
              `spu_id`,
              `sku_id`,
              `order_no`,
              `user_id`,
              `nickname`,
              `comment`,
              `source`,
              `images`  
            from 
              `{$this->order_goods_comments}` 
            where 
              `order_id`=?
EOF;
        $rows = $this->slave->select($sql, [$order_id]);

        return $rows;
    }

    /**
     * query goods with wait comment
     *
     * @param int $order_id
     * @param int $sku_id           指定商品 默认null 不指定
     *
     * @return array
     */
    public function queryGoodsWithWaitComment(int $order_id, int $sku_id): array
    {
        $sql  = <<<EOF
            SELECT 
                g.`id`,
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
                g.`updated_at`
            FROM 
                `{$this->order_goods}` g
            LEFT JOIN 
                `{$this->order_goods_comments}` c 
                ON g.`order_id`=c.`order_id` 
            WHERE 
                g.`order_id`=? AND 
                c.id IS NULL
EOF;
        $where = [$order_id];
        if (!empty($sku_id)) {
            $sql .= " AND g.`sku_id`=?";
            array_push($where, $sku_id);
        }
        $rows = $this->slave->select($sql, $where);

        return $rows;
    }

}