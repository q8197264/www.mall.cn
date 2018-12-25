<?php
namespace App\AppServices\Services\Cart;


/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-17
 * Time: 22:30
 */
class Cart extends AbstractCart
{
    public function initialize() {}

    public function findCartList(int $uid)
    {
        $list = $this->getCartRespository()->getCartList($uid);

        return $list;
    }

    /**
     * get goods by selected
     *
     * @param int $user_id
     *
     * @return mixed
     */
    public function findListBySelected(int $user_id)
    {
        $res = $this->getCartRespository()->getCartList($user_id, true);

        return $res;
    }

    public function add(int $user_id, int $spu_id, int $sku_id, int $shop_id, int $number):bool
    {
        return $this->getCartRespository()->add($user_id, $spu_id, $sku_id, $shop_id, $number);
    }

    /**
     * modify cart goods number
     *
     * @param int $id               cart id
     * @param int $number           buy goods number
     *
     * @return mixed
     */
    public function modify(int $id, int $number):bool
    {
        return $this->getCartRespository()->updateCartGoodsNumber($id, $number);
    }

    /**
     * Is the product selected ?
     *
     * @param int  $cart_id
     * @param bool $checked
     *
     * @return mixed
     */
    public function selected(int $cart_id, bool $isChecked):bool
    {
        $bool = $this->getCartRespository()->updateSelectedById($cart_id, $isChecked);

        return $bool;
    }

    /**
     * Clean goods selected
     *
     * @return bool
     */
    public function removeBySelected(int $user_id):bool
    {
        $bool = $this->getCartRespository()->delBySelected($user_id);

        return $bool;
    }
}