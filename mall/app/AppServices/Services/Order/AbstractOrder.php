<?php
namespace App\AppServices\Services\Order;

use Illuminate\Container\Container as App;

/**
 * Order.
 *
 * User: sai
 * Date: 2018-12-19
 * Time: 21:11
 */
abstract class AbstractOrder
{
    protected static $orderRepository;
    protected static $app;

    public function __construct(App $app)
    {
        static::$app = $app;

        if (empty(static::getOrderRepository())) {
            static::$orderRepository = $app->make(
                'App\AppServices\Repositories\Order\OrderRepository');
        }
        $this->initialize();
    }

    protected function getOrderRepository()
    {
        return static::$orderRepository;
    }

    abstract protected function initialize();
}