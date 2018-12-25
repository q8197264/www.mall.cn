<?php
namespace App\AppServices\Repositories\Cart;

use App\AppServices\Models\CartModel;
use App\AppServices\Models\GoodsModel;

class CartRepository
{
    protected $cartModel;
    protected $goodsModel;

    public function __construct(CartModel $cartModel, GoodsModel $goodsModel)
    {
        $this->cartModel = $cartModel;
        $this->goodsModel = $goodsModel;
    }

    /**
     * get cart list with spec
     *
     * @param int $uid
     *
     * @return mixed
     */
    public function getCartList(int $uid=0, bool $selected=false)
    {
        $cartList = $this->cartModel->getCartList($uid, $selected);
        $sku_ids = array_column($cartList, 'sku_id');

        $res = [];
        if (!empty($sku_ids)) {
            $specs = $this->goodsModel->getSpecBySkuid($sku_ids);

            //不同规格，同sku_id分为一组

            foreach ($specs as $row) {
                $res[$row->sku_id][] = $row;
            }

            //同sku_id规格对应到同商品sku_id
            foreach ($sku_ids as $index=>$sku_id) {
                if (isset($res[$sku_id]) && ($cartList[$index]->sku_id==$sku_id)) {
                    $cartList[$index]->spec = $res[$sku_id];
                }
            }

            $res = [];
            foreach ($cartList as $item) {
                $shop = $this->goodsModel->queryGoodsShopById($item->shop_id);
                $res[$item->shop_id]['shop'] = $shop;
                $res[$item->shop_id]['cart_goods'][] = $item;
            }
        }

        return $res;
    }

    /**
     * add goods to cart
     *
     * @param int $user_id
     * @param int $spu_id
     * @param int $sku_id
     * @param int $shop_id
     * @param int $number
     *
     * @return bool|mixed
     */
    public function add(int $user_id, int $spu_id, int $sku_id, int $shop_id, int $number)
    {
        $bool = false;

        //查询购物车内是否已存在相应数据
        $cart = $this->cartModel->getById($user_id, $spu_id, $sku_id, $shop_id);

        //追加购物车数量，爆仓自平
        //这里用db可加for update锁
        $sku = $this->goodsModel->getSkuById($sku_id, $spu_id, $shop_id);

        if (empty($sku['stock'])) {
            return $bool;
        }
        if ( !empty($cart)) {
            if ($cart['spu_numbers']+$number <= $sku['stock']) {
                $bool = $this->cartModel->addStock($cart['cart_id'], $number);
            }
        } else {
            $bool = $this->cartModel->add($user_id, $spu_id, $sku_id, $shop_id, $number, $sku['price']);
        }

        return $bool;
    }

    /**
     * update goods number
     *
     * @param int $id
     * @param int $number
     *
     * @return bool
     */
    public function updateCartGoodsNumber(int $id, int $number):bool
    {
        return $this->cartModel->updateCartGoodsNumber($id, $number);
    }

    /**
     * Is the product selected
     *
     * @param int $cart_id
     * @param int $isChecked
     *
     * @return bool
     */
    public function updateSelectedById(int $cart_id, bool $isChecked):bool
    {
        return $this->cartModel->updateSelectedById($cart_id, $isChecked);
    }

    /**
     * bath del goods selected
     *
     * @return mixed
     */
    public function delBySelected(int $user_id):bool
    {
        return $this->cartModel->delBySelected($user_id);
    }
}