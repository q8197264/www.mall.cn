<?php
namespace App\AppServices\Services\Comment;

/**
 * Comment service
 *
 * User: sai
 * Date: 2018-12-23
 * Time: 23:59
 */
class Comment extends AbstractComment
{
    protected function initialize()
    {
        // TODO: Implement initialize() method.
        //$this->app->make('');
    }

    public function getGoodsWithCommented(int $order_id)
    {
        return $this->getCommentRepository()->queryGoodsWithCommented($order_id);
    }

    /**
     * get goods with wait comment
     *
     * @param int $order_id
     *
     * @return mixed
     */
    public function getGoodsWithWaitComment(int $order_id, int $sku_id):array
    {
        return $this->getCommentRepository()->queryGoodsWithWaitComment($order_id, $sku_id);
    }

    public function add()
    {

    }
}