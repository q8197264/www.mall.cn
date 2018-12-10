<?php
namespace App\Services\Goods;

/**
 * Created by PhpStorm.
 * User: liuxiaoquan
 * Date: 2018-12-10
 * Time: 16:39
 */
class Admin extends AbstractGoods
{
    protected function initialize()
    {
        // TODO: Implement initialize() method.
    }
    
    public function list(int $offset, int $limit)
    {
        $this->getGoodsRespository()->list($offset, $limit);
        
    }
}