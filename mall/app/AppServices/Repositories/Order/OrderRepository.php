<?php
namespace App\AppServices\Repositories\Order;

use App\AppServices\Models\OrderModel;

/**
 * Order Repository.
 * User: sai
 * Date: 2018-12-21
 * Time: 00:28
 */
class OrderRepository
{
    protected $orderModel;

    public function __construct(OrderModel $orderModel)
    {
        $this->orderModel = $orderModel;
    }

    public function add()
    {}
}