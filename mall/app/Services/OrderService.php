<?php
/**
 * Created by PhpStorm.
 * User: liuxiaoquan
 * Date: 2018-11-22
 * Time: 21:35
 */

namespace App\Services;


class OrderService
{
    public function __construct()
    {

    }

    public function getDiscount($qty)
    {
        if ($qty == 1) {
            return 1.0;
        } elseif ($qty == 2) {
            return 0.9;
        } elseif ($qty == 3) {
            return 0.8;
        } else {
            return 0.7;
        }
    }

    public function getTotal($qty, $discount)
    {
        return 500 * $qty * $discount;
    }
}