<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\AppServices\Services\NavigateService;
use App\Http\Controllers\Controller;

/**
 * 后台导分类导航类.
 * User: liuxiaoquan
 * Date: 2018-12-03
 * Time: 11:36
 */
class NavigatesController extends Controller
{
    private $navigateService;

    public function __construct(NavigateService $navigateService)
    {
        $this->navigateService = $navigateService;
    }

    /**
     * 展示后台分类导航列表
     */
    public function show()
    {
        $list = $this->navigateService->show();

        echo json_encode($list);
        return view('admin.navigate');
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

        $bool = $this->navigateService->add($pid, $cname);

        echo $bool;
    }


    public function del(Request $request)
    {
        $cid = $request->input('cid');

        $bool = $this->navigateService->del($cid);

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

        $bool = $this->navigateService->edit($cid, $name);

        echo $bool;
    }
}