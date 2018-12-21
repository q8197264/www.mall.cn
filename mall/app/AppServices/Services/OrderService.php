<?php
namespace App\AppServices\Services;

use App\AppServices\Services\Order\Admin;
use App\AppServices\Services\Order\Order;


/**
 * Order .
 *
 * User: liuxiaoquan
 * Date: 2018-11-22
 * Time: 21:35
 */
class OrderService
{
    protected $order;
    protected $admin;
    protected $addressService;
    protected $cartService;

    public function __construct(Order $order, Admin $admin, AddressService $addressService, CartService $cartService)
    {
        $this->order          = $order;
        $this->admin          = $admin;
        $this->addressService = $addressService;
        $this->cartService    = $cartService;
    }

    public function getList() {}

    public function show() {}

    public function create(int $user_id)
    {
        try{
            $res = $this->order->create($user_id);
        }catch(\Exception $e){
            $res['code'] = $e->getCode();
            $res['msg'] = $e->getMessage();
        }

        return $res;
    }

}