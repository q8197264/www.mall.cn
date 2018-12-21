<?php
namespace App\AppServices\Services\Order;


use mysql_xdevapi\Exception;

/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-19
 * Time: 20:48
 */
class Order extends AbstractOrder
{
    protected $cartService;
    protected $addressService;

    protected function initialize()
    {
        $this->cartService    = static::$app->make('App\AppServices\Services\CartService');
        $this->addressService = static::$app->make('App\AppServices\Services\AddressService');
    }

    public function create(int $user_id)
    {
        if (empty($user_id)) {
            throw new Exception('user_id is null');
        }

        //address from db
        $info = $this->addressService->findDefaultByUid($user_id);

        //pay way from page
        //shipping way from page

        //goods form cart by selected
        //insert order_info
        //insert order_item
        $goods = $this->cartService->findListBySelected($user_id);

        dd($info,$goods);
    }
}