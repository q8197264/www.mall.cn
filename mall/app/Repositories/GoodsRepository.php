<?php
namespace App\Repositories;

use App\Models\GoodsModel;

/**
 * 商品数据模型.
 * User: liuxiaoquan
 * Date: 2018-12-10
 * Time: 17:46
 */
class GoodsRepository
{
    protected $goodsModel;

    public function __construct(GoodsModel $goodsModel)
    {
        $this->goodsModel = $goodsModel;
    }

    public function list(int $offset, int $limit)
    {
        $this->goodsModel->queryGoodsList();
    }
    
    
}