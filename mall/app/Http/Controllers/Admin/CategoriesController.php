<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\AppServices\Services\CategoryService;
use App\Http\Controllers\Controller;

/**
 * 分类管理.
 *
 * User: sai
 * Date: 2018-12-11
 * Time: 15:05
 */
class CategoriesController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function show()
    {
        $category = $this->categoryService->show();

        echo json_encode($category);
        return view('admin.category.category', ['data'=>$category]);
    }

    public function add(Request $request)
    {
        $cname = $request->input('cname');
        $tid   = $request->input('tid');

        echo $this->categoryService->add($tid, $cname);
    }

    public function del(Request $request)
    {
        $id = $request->input('id');

        echo $this->categoryService->del($id);
    }

    public function edit(Request $request)
    {
        $id    = $request->input('id');
        $tid   = $request->input('tid');
        $cname = $request->input('cname');

        echo $this->categoryService->edit($id, $tid, $cname);
    }
}