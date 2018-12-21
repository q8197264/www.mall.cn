<?php
namespace App\AppServices\Services;

use App\AppServices\Services\Cart\Cart;

/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-17
 * Time: 22:29
 */
class CartService
{
    protected $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * show cart data with user
     *
     * @param int $uid
     *
     * @return mixed
     */
    public function findCartList(int $uid)
    {
        $list = $this->cart->findCartList($uid);

        return $list;
    }

    /**
     * get goods of selected
     *
     * @param int $user_id
     *
     * @return mixed
     */
    public function findListBySelected(int $user_id)
    {
        $list = $this->cart->findListBySelected($user_id);

        return $list;
    }

    public function findById(int $uid){

    }

    /**
     * add cart data with user
     *
     * @param int $spu_id
     * @param int $sku_id
     * @param int $user_id
     *
     * @return bool
     */
    public function add(int $user_id, int $spu_id, int $sku_id, int $shop_id, int $number):bool
    {
        return $this->cart->add($user_id, $spu_id, $sku_id, $shop_id, $number);
    }

    //edit nubmer
    public function modify(int $id, int $number):bool
    {
        return $this->cart->modify($id, $number);
    }

    /**
     * Is the product selected ?
     *
     * @param int  $cart_id
     * @param bool $checked
     *
     * @return mixed
     */
    public function selected(int $cart_id=0, bool $isChecked=false):bool
    {
        return $this->cart->selected($cart_id, $isChecked);
    }

    public function remove(){}

}