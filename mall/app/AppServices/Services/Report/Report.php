<?php

namespace Services\Report;

use Exception;
use Services\SERProxy\AbstractCall;
use App\AppServices\Repositories\Order\OrderRepository;

/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-28
 * Time: 17:18
 */
class Report extends AbstractCall
{
    //连贯操作时指向下一个类
    static $ActionNamespace = 'Services\Report\Action';

    protected $orderRepository;


    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function show()
    {
        dd('show');
    }

    public function fetch()
    {
        return $this;
    }
}