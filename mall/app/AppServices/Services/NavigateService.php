<?php
namespace App\AppServices\Services;

use App\AppServices\Services\Navigate\Navigate;
use App\AppServices\Services\Navigate\Admin;

/**
 * 分类导航接口.
 *
 * User: liuxiaoquan
 * Date: 2018-12-03
 * Time: 11:43
 */
class NavigateService
{
    private $navigate;
    private $admin;

    public function __construct(Navigate $navigate, Admin $admin)
    {
        $this->navigate = $navigate;
        $this->admin    = $admin;
    }

    public function show():array
    {
        return $this->admin->show();
    }

    public function add(int $pid, string $cname):bool
    {
        return $this->admin->add($pid, $cname);
    }

    public function edit(int $cid, string $cname):bool
    {
        return $this->admin->edit($cid, $cname);
    }

    public function del(int $cid) :bool
    {
        return $this->admin->del($cid);
    }
}