<?php
namespace App\AppServices\Services;

use App\AppServices\Services\Category\Category;
use App\AppServices\Services\Category\Admin;

/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-11
 * Time: 16:42
 */
class CategoryService
{
    private $category;
    private $admin;

    public function __construct(Category $category, Admin $admin)
    {
        $this->admin    = $admin;
        $this->category = $category;
    }

    public function show() :array
    {
        return $this->admin->show();
    }

    public function add(int $tid, string $cname):bool
    {
        return $this->admin->add($tid, $cname);
    }

    public function del(int $id):bool
    {
        return $this->admin->del($id);
    }

    public function edit(int $id, int $tid, string $cname):bool
    {
        return $this->admin->edit($id, $tid, $cname);
    }
}