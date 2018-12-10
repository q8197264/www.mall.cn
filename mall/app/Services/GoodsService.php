<?php
namespace App\Services;

use App\Services\Goods\Goods;
use App\Services\Goods\Admin;

/**
 * 商品管理模块.
 * User: liuxiaoquan
 * Date: 2018-12-10
 * Time: 16:37
 */
class GoodsService
{
    protected $goods;
    protected $amind;

    public function __construct(Goods $goods, Admin $admin)
    {
        $this->goods = $goods;
        $this->admin = $admin;
    }

    public function list(int $offset, int $limit)
    {
        $list = $this->admin->list($offset, $limit);
        
        echo json_encode($list);
    }
}