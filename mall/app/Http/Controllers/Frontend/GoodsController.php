<?php
namespace App\Http\Controllers\Frontend;

use App\AppServices\Services\CommentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppServices\Services\GoodsService;
use App\AppServices\Services\Comment;

class GoodsController extends Controller
{
    protected $goodsService;
    protected $commentService;

    //
    public function __construct(GoodsService $goodsService, CommentService $commentService)
    {
        $this->goodsService = $goodsService;
        $this->commentService = $commentService;
    }

    public function show(int $gid=0)
    {
        $data = $this->goodsService->info($gid);
        foreach ($data['sku'] as $sku_id=>$sku) {
            $data['sku'][$sku_id]['comments'] = $this->commentService
                ->getCommentWithGoods($data['id'], $sku_id);
        }

        //echo json_encode($data);
        return view('frontend.goods.detail',['data'=>$data]);
    }

    public function list(int $offset=0)
    {
        $list = $this->goodsService->list($offset, 10);

        return view('frontend.home', ['data'=>$list]);
    }

}
