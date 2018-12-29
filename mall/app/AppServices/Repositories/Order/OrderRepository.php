<?php
namespace App\AppServices\Repositories\Order;

use App\AppServices\Models\OrderModel;
use App\AppServices\Models\GoodsModel;

/**
 * Order Repository.
 * User: sai
 * Date: 2018-12-21
 * Time: 00:28
 */
class OrderRepository
{
    protected $orderModel;

    public function __construct(OrderModel $orderModel, GoodsModel $goodsModel)
    {
        $this->orderModel = $orderModel;
        $this->goodsModel = $goodsModel;
    }

    /**
     * 建造订单
     *
     * @param array $order
     * @param array $goodsList
     *
     * @return int
     */
    public function builder(array $order, array $goodsList):array
    {
        if (empty($order) || empty($goodsList)) {
            return [];
        }
        $order['order_sn'] = $this->genOrderSn($order['user_id']);

        $order_id = $this->orderModel->addOrderAndRelateGoods($order, $goodsList);

        return ['order_id'=>$order_id,'order_sn'=>$order['order_sn']];
    }

    /**
     * 订单编号
     * 保证唯一性: 机器ID+时间戳+自增序列(用随机数代替)+userid后4位）
     * 24=10 + 6 + id + userid
     *
     * @return string
     */
    protected function genOrderSn(int $user_id):string
    {
        $machineId = (new GetMacAddr())::getMachineId();
        $order_sn = strtoupper($machineId).time().rand(0,10000).$user_id;

        return $order_sn;
    }


    /**
     * get order relate goods list
     *
     * @param int $order_id
     *
     * @return array
     */
    public function getOrderRelateGoods(int $order_id):array
    {
        $list = $this->orderModel->queryGoodsByOrderId($order_id);
        foreach ($list as $k=>$row) {
            $list[$k]->shop_name   = $this->goodsModel->queryGoodsShopById($row->shop_id)['shop_name'];
        }

        return $list;
    }


    public function getSales(string $start, string $end)
    {
        $list = $this->orderModel->querySales($start, $end);

        return $list;
    }
}