<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\OrderService;

class OrdersController extends Controller
{
    private $orderservice;

    public function __construct(OrderService $orderService)
    {
        $this->orderservice = $orderService;
    }

    public function show(int $id)
    {
        echo 'order';
    }

    public function store(Request $request)
    {
        $qty = $request->input('qty');

        $discount = $this->orderservice->getDiscount($qty);
        $total    = $this->orderservice->getTotal($qty, $discount);

        echo $total;
    }
}
