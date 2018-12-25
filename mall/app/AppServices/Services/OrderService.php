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

    /**
     * Generate order
     *
     * @param int $user_id
     */
    public function create(int $user_id)
    {
        try{
            $res['data'] = $this->order->create($user_id);
        }catch(\Exception $e){
            $res['code'] = 1;
            $res['msg'] = $e->getMessage();
            $res['errfile'] = $e->getTrace()[0];
        }finally{
            $res['code'] = $res['code']??0;
        }

        return $res;
    }

    /**
     * get order relate goods list
     *
     * @param int $order_id
     *
     * @return mixed
     */
    public function getOrderRelateGoods(int $order_id, string $order_sn='')
    {
        try{
            $res['data'] = $this->order->getOrderRelateGoods($order_id, $order_sn);
        }catch(\Exception $e){
            $res['code'] = 1;
            $res['msg'] = $e->getMessage();
            $res['errfile'] = $e->getTrace()[0];
        }finally{
            $res['code'] = $res['code']??0;
        }

        return $res;
    }

}