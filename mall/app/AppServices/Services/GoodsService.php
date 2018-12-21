<?php
namespace App\AppServices\Services;

use App\AppServices\Services\Goods\Goods;
use App\AppServices\Services\Goods\Admin;

/**
 * 商品管理模块.
 *
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

    public function list(int $offset=0, int $limit=10):array
    {
        $list = $this->admin->list($offset, $limit);

        return $list;
    }

    public function info(int $gid):array
    {
        return $this->admin->info($gid);
    }

    public function add(array $data): bool
    {
        return $this->admin->add($data);
    }

    /**
     * 更新商品信息
     *
     * @param int    $id            商品id
     * @param string $gname         商品名称
     * @param float  $low_price     最低价格
     * @param int    $cid           分类id
     * @param int    $bid           品牌id
     *
     * @return bool
     */
    public function edit(int $id, string $gname, float $low_price, int $cid, int $bid): bool
    {
        return $this->admin->edit($id, $gname, $low_price, $cid, $bid);
    }

    public function del()
    {}
}