<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppServices\Services\GoodsService;

class GoodsController extends Controller
{
    protected $goodsService;

    //
    public function __construct(GoodsService $goodsService)
    {
        $this->goodsService = $goodsService;
    }

    public function show(int $gid=0)
    {
        $data = $this->goodsService->info($gid);
        //echo json_encode($data);
        return view('frontend.goods.detail',['data'=>$data]);
    }

    public function list(int $offset=0)
    {
        $list = $this->goodsService->list($offset, 10);

        return view('frontend.home', ['data'=>$list]);
    }

}
