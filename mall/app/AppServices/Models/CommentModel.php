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

    public function addOnlyComment(array $parameters)
    {
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
                  ?,?,?,?,?,?,?,?,?,?,?
                )
EOF;
dd($parameters);
        $id = $this->master->insert($sql, [$order_id, $sku_id, $spu_id, $comment_content]);

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
    public function addCommentAndImage(int $comment_id, string $path):int
    {
        $sql = <<<EOF
            INSERT INTO `{$this->order_goods_comment_images}` ( 
              `comment_id`, 
              `path`, 
              `created_at`, 
              `updated_at` 
            ) VALUE
                ( ?,?,?,? )
EOF;
        $now = date('Y-m-d H:i:s', time());
        $id = $this->master->insert($sql, [$comment_id, $path, $now, $now]);

        return $id;
    }

}