<?php
namespace App\Services\Goods;

use Illuminate\Container\Container as App;

/**
 * 商品接口.
 * User: liuxiaoquan
 * Date: 2018-12-10
 * Time: 16:48
 */
abstract class AbstractGoods
{
    protected static $goodsRespository;

    public function __construct(App $app)
    {
        if (empty(static::getGoodsRespository())) {
            static::$goodsRespository = $app->make('App\Repositories\GoodsRepository');
        }
        $this->initialize();
    }

    abstract protected function initialize();

    protected function getGoodsRespository()
    {
        return static::$goodsRespository;
    }
}