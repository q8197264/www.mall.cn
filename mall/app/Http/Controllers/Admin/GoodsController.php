<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppServices\Services\GoodsService;

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

    public function list(int $offset = 0)
    {
        $list = $this->goodsService->list($offset, 10);

        return view('admin.goods.goods', ['data'=>$list]);
    }

    public function show(int $gid=0)
    {
        $data = $this->goodsService->info($gid);

        echo json_encode($data);
    }

    public function add(Request $request)
    {
        echo '<pre>';
        $data['goods_name']  = $request->input('gname');
        $data['description'] = $request->input('description');
        $data['category_id'] = $request->input('cid');
        $data['brand_id']    = $request->input('bid');
        $data['spec']        = $request->input('spec');
        $data['spec_value']  = $request->input('spec_value');
        $data['sku_name']    = $request->input('sku_name');
        $data['low_price']   = $request->input('lprice');
        $data['shop_id']     = $request->input('shopid');
        $data['stock']       = $request->input('stock');

        echo $this->goodsService->add($data);
    }

    public function edit(Request $request)
    {
        echo '<pre>';
        $id          = $request->input('id');
        $goods_name  = $request->input('gname');
        $low_price   = $request->input('lprice');
        $category_id = $request->input('cid');
        $brand_id    = $request->input('bid');
        $data = $this->goodsService->edit($id, $goods_name, $low_price, $category_id, $brand_id);

        echo json_encode($data);
    }

    public function delete(Request $request)
    {
        echo 'delete';
    }
}