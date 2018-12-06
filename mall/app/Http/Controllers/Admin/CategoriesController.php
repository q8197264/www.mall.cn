<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;

/**
 * 后台导分类导航类.
 * User: liuxiaoquan
 * Date: 2018-12-03
 * Time: 11:36
 */
class CategoriesController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $CategoryService)
    {
        $this->categoryService = $CategoryService;
    }

    /**
     * 展示分类导航列表
     */
    public function show()
    {
        $list = $this->categoryService->showAdminCategory();

        echo json_encode($list);
        return view('admin.category');
    }

    /**
     * 添加分类
     *
     * @param Request $request
     */
    public function add(Request $request)
    {
        $pid = $request->input('pid');
        $cname = $request->input('name');

        $bool = $this->categoryService->addAdminCategory($pid, $cname);

        echo $bool;
    }


    public function delete(Request $request)
    {
        $cid = $request->input('cid');

        $bool = $this->categoryService->delAdminCategory($cid);

        echo $bool;
    }

    /**
     * 更新分类
     *
     * @param Request $request
     */
    public function edit(Request $request)
    {
        $cid = $request->input('cid');
        $name = $request->input('name');

        $bool = $this->categoryService->editAdminCategory($cid, $name);

        echo $bool;
    }
}