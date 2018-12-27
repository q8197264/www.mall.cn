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
     * @param int $sku_id 指定商品 默认null 不指定
     *
     * @return array
     */
    public function queryGoodsWithWaitComment(int $order_id, int $sku_id): array
    {
        $sql   = <<<EOF
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

    public function addOnlyComment(array $parameters)
    {
        if (empty($parameters['comment'])) {
            return 0;
        }
        $sql = <<<EOF
            insert into 
              `{$this->order_goods_comments}`(
                  `order_no`,
                  `order_id`,
                  `spu_id`,
                  `sku_id`,
                  `user_id`,
                  `nickname`,
                  `comment`,
                  `source`,
                  `images`,
                  `created_at`,
                  `updated_at`
                )value(
                  ?,?,?,?,?,?,?,0,'',?,?
                )
EOF;
        $now = date('Y-m-d H:i:s', time());
        $id  = $this->master->insert($sql, [
            $parameters['order_no'],
            $parameters['order_id'],
            $parameters['spu_id'],
            $parameters['sku_id'],
            $parameters['user_id'],
            $parameters['nickname'],
            $parameters['comment'],
            $now,
            $now
        ]);

        return $id;
    }

    /**
     * comment images
     *
     * @param int    $comment_id
     * @param string $path
     *
     * @return mixed
     */
    public function addCommentAndImage(array $parameters): int
    {
        $id = $this->master->transaction(function () use ($parameters) {
            $now = date('Y-m-d H:i:s', time());
            $id  = $this->master->table($this->order_goods_comments)->insertGetId([
                'order_no'   => $parameters['order_no'],
                'order_id'   => $parameters['order_id'],
                'spu_id'     => $parameters['spu_id'],
                'sku_id'     => $parameters['sku_id'],
                'user_id'    => $parameters['user_id'],
                'nickname'   => $parameters['nickname'],
                'comment'    => $parameters['comment'],
                'source'     => 0,
                'images'     => '',
                'created_at' => $now,
                'updated_at' => $now
            ]);

            foreach ($parameters['image_list'] as $path) {
                $this->master->table($this->order_goods_comment_images)->insert([
                    'comment_id' => $id,
                    'path'       => $path,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }

            return $id;
        }, 2);

        return $id;
    }

}