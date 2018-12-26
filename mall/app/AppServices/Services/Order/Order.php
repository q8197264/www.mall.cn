<?php

namespace App\AppServices\Services\Order;

use App\Events\OrderPaid;
use Exception;

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

    /**
     * Order generator
     *
     * @param int $user_id
     *
     * @throws Exception
     */
    public function create(int $user_id)
    {
        if (empty($user_id)) {
            throw new Exception('user_id is no exists');
        }

        //address from db
        $address = $this->addressService->findDefaultByUid($user_id);
        if (empty($address)) {
            throw new Exception('No default address is set.');
        }

        //goods form cart by selected
        $list = $this->cartService->findListBySelected($user_id);
        if (empty($list)) {
            throw new Exception('No goods selected in cart');
        }

        $now = date('Y-m-d H:i:s', time());

        $res = [];
        foreach ($list as $shop_id => $shop) {
            foreach ($shop['cart_goods'] as $k => $goods) {
                if ($goods->status != 0 || ($goods->stock < $goods->spu_numbers)) {
                    continue;
                }
                $goodsList[$k]['spu_id']     = $goods->spu_id;
                $goodsList[$k]['sku_id']     = $goods->sku_id;
                $goodsList[$k]['shop_id']    = $goods->shop_id;
                $goodsList[$k]['number']     = $goods->spu_numbers;
                $goodsList[$k]['sku_price']  = $goods->price;
                $goodsList[$k]['total_fee']  = $goods->price * $goods->spu_numbers;
                $goodsList[$k]['images']     = $goods->images;
                $goodsList[$k]['created_at'] = $now;
                $goodsList[$k]['updated_at'] = $now;
                $goodsList[$k]['stock']      = $goods->stock;
            }
            if (empty($goodsList)) {
                continue;
            }
            $order['user_id']       = $user_id;
            $order['address_id']    = $address['id'];
            $order['goods_count']   = count($shop['cart_goods']);
            $order['trade_status']  = 0;
            $order['pay_id']        = 0;//货到付款
            $order['shop_id']       = $shop_id;
            $order['goods_amount']  = $this->getOrderGoodsAmount($shop['cart_goods']);
            $order['shipping_fee']  = $this->getOrderShippingFee();
            $order['order_amount']  = $order['goods_amount'] + $order['shipping_fee'];
            $order['shipping_name'] = '快递';
            $order['remark']        = '用户留言';
            $order['created_at']    = $now;
            $order['updated_at']    = $now;

            //add to order table
            $order_res= $this->getOrderRepository()->builder($order, $goodsList);
            $res[$shop_id]['order_id'] = $order_res['order_id'];
            $res[$shop_id]['order_sn'] = $order_res['order_sn'];
            $res[$shop_id]['order_amount'] = $order['order_amount'];
            $res[$shop_id]['shop_name'] = $shop['shop']['shop_name'];
        }

        //删除购物车
        if (!empty($order_res)) {
            $this->cartService->removeBySelected($user_id);

            $this->sendUserNotify($res);
        } else {
            throw new Exception('商品库存不足或已下架');
        }

        return $res;
    }

    /**
     * @param array $notifies
     */
    protected function sendUserNotify(array $notifies)
    {
        //send message
        foreach ($notifies as $k=>$v) {
            event(new OrderPaid($v));
        }
    }

    /**
     * compute the shop goods total goods
     *
     * @param array $goodsList
     *
     * @return int
     */
    protected function getOrderGoodsAmount(array $goodsList)
    {
        $amount = 0;
        foreach ($goodsList as $goods) {
            $amount += $goods->price;
        }

        return $amount;
    }

    //TODO:
    protected function getOrderShippingFee()
    {
        return 0;
    }


    /**
     * get order relate goods list
     *
     * @param int    $order_id
     * @param string $ordersn
     *
     * @return mixed
     */
    public function getOrderRelateGoods(int $order_id, string $ordersn='')
    {
        $list = $this->getOrderRepository()->getOrderRelateGoods($order_id);

        return $list;
    }

}




