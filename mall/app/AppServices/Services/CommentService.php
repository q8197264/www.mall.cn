<?php
namespace App\AppServices\Services;

use App\AppServices\Services\Comment\Comment;
use App\AppServices\Services\Comment\Admin;

/**
 * Comment .
 * User: sai
 * Date: 2018-12-23
 * Time: 23:59
 */
class CommentService
{
    protected $comment;
    protected $amdmin;

    public function __construct(Comment $commnet, Admin $admin)
    {
        $this->comment = $commnet;
        $this->admin = $admin;
    }

    /**
     *
     * @param array $parameters
     *             [
     *             int $user_id,
     *             int $sku_id,
     *             int $order_id,
     *             string $order_sn
     *             comment_content
     *             paths
     * ]
     *
     *
     */
    public function save(array $parameters=[])
    {
        try{
            $res = $this->comment->save($parameters);
        }catch(\Exception $e){
            $res['error'] = 1;
            $res['msg'] = $e->getMessage();
        }

        return $res;
    }

    /**
     * 可以评论的商品
     *
     * @param int $user_id
     * @param int $order
     */
    public function getGoodsWithCommented(int $order_id)
    {
        $list = $this->comment->getGoodsWithCommented($order_id);

        return $list;
    }

    /**
     * get goods with wait comment
     *
     * @param int $order_id
     *
     * @return mixed
     */
    public function getGoodsWithWaitComment(int $order_id, int $sku_id = 0):array
    {
        $list = $this->comment->getGoodsWithWaitComment($order_id, $sku_id);

        return $list;
    }

}