<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GoodsService;

/**
 * 商品模块.
 * User: liuxiaoquan
 * Date: 2018-12-10
 * Time: 16:22
 */
class GoodsController extends Controller
{
    protected $goodsService;

    public function __construct(GoodsService $goodsService)
    {
        $this->goodsService = $goodsService;
    }

    public function list(int $offset=0, int $limit=10)
    {
        $this->goodsService->list($offset, $limit);

        return view('admin.goods.goods');
    }

    public function show(int $gid)
    {
        echo 'show'.$gid;
    }

    public function add(Request $request)
    {

    }

    public function delete()
    {}

    public function edit()
    {}
}