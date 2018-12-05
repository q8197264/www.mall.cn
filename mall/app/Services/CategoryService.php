<?php
namespace App\Services;

use App\Services\Category\Goods;
use App\Services\Category\Admin;

/**
 * 分类导航接口.
 * User: liuxiaoquan
 * Date: 2018-12-03
 * Time: 11:43
 */
class CategoryService
{
    private $goods;
    private $admin;

    public function __construct(Goods $goods, Admin $admin)
    {
        $this->goods = $goods;
        $this->admin = $admin;
    }

    public function showAdminCategory():array
    {
        return $this->admin->showCategory();
    }

    public function addAdminCategory(int $pid, string $cname):bool
    {
        return $this->admin->addCategory($pid, $cname);
    }

    public function editAdminCategory(int $cid, string $cname):bool
    {
        return $this->admin->editCategory($cid, $cname);
    }

    public function delAdminCategory(int $cid) :bool
    {
        return $this->admin->delCategory($cid);
    }

    
    public function showGoodsCategorys()
    {}
}