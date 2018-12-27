<?php
namespace App\AppServices\Repositories\Comment;

use App\AppServices\Models\CommentModel;
use App\AppServices\Models\GoodsModel;
use App\AppServices\Models\UserModel;
use App\User;

/**
 * Comment repository.
 *
 * User: sai
 * Date: 2018-12-24
 * Time: 00:13
 */
class CommentRepository
{
    protected $commentModel;
    protected $goodsModel;
    protected $userModel;

    public function __construct(CommentModel $commentModel, GoodsModel $goodsModel, UserModel $userModel)
    {
        $this->commentModel = $commentModel;
        $this->goodsModel   = $goodsModel;
        $this->userModel = $userModel;
    }

    /**
     *
     * goods commented
     *
     * @param int $user_id
     * @param int $order_id
     *
     * @return mixed
     */
    public function queryGoodsWithCommented(int $order_id)
    {
        return $this->commentModel->queryGoodsWithCommented($order_id);
    }

    /**
     * wait comment goods
     *
     * @return mixed
     */
    public function queryGoodsWithWaitComment(int $order_id, int $sku_id = 0):array
    {
        $list = $this->commentModel->queryGoodsWithWaitComment($order_id, $sku_id);
        foreach ($list as $k=>$goods) {
            $sku = $this->goodsModel->getSkuById($goods->sku_id, $goods->spu_id, $goods->shop_id);
            $list[$k]->shop_name = $this->goodsModel->queryGoodsShopById($goods->shop_id)['shop_name'];
            $list[$k]->sku_name = $sku['sku_name'];
            $list[$k]->sku_price = $sku['price'];
            $list[$k]->sku_images = $sku['images'];
        }

        return $list;
    }

    public function add(array $parameters):int
    {
        if (empty($parameters['comment'])) {
            return 0;
        }
        $user = $this->userModel->queryUserByIndex(['id'=>$parameters['user_id']]);
        $parameters['nickname'] = $user['nickname'];

        if (empty($parameters['image_list'])) {
            $id = $this->commentModel->addOnlyComment($parameters);
        } else {
            $id = $this->commentModel->addCommentAndImage($parameters);
        }

        return $id;
    }

}