<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\AppServices\Services\CommentService;
use App\AppServices\Services\OrderService;
use Libraries\Wechat\Jssdk\JSSDK;

/**
 * Goods Comment.
 * User: sai
 * Date: 2018-12-22
 * Time: 20:41
 */
class CommentController extends Controller
{
    protected $commentService;
    protected $orderService;

    public function __construct(CommentService $commentService, OrderService $orderService)
    {
        $this->commentService = $commentService;
        $this->orderService = $orderService;
    }

    /**
     * 待评论商品list
     *
     * @param int $order_id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $order_id)
    {
        $user_id = $this->isLogin();

        $list = $this->commentService->getGoodsWithWaitComment($order_id);

        return view('frontend.comment.intolink', ['list'=>$list]);
    }

    /**
     * show input form
     *
     * @param int $order_id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function todo(int $order_id, int $sku_id)
    {
        $user_id =$this->isLogin();

        $list = $this->commentService->getGoodsWithWaitComment($order_id, $sku_id);

        $jssdk = new JSSDK();
        $config = $jssdk->GetSignPackage();
        //$jssdk->downloadImage();

        return view('frontend.comment.add',['list'=>$list, 'config'=>$config]);

    }


    /**
     * submit comment
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request)
    {
//        $user_id  = $this->isLogin();
//        $sku_id   = $request->input('sid');
//        $order_id = $request->input('oid');
//        $order_sn = $request->input('osn');
//        $this->commentService->add($user_id, $sku_id, $order_id, $order_sn);
//        $goods = $this->

        $MEDIA_ID = $request->input('mediaIds');

        //$res = (new JSSDK())->downloadImage($MEDIA_ID);
        echo json_encode($MEDIA_ID);
        //return view('frontend.comment.add', ['config'=>$config]);
    }

    public function detail()
    {
//        $spu_id;
//        $sku_id;
//        $order_no;

    }

    /**
     * kind of goods with different status
     */
    public function list()
    {

    }

    /**
     * check user login status
     *
     * @return int
     */
    protected function isLogin():int
    {
        $user_id = session('user_id');
        if (empty($user_id)) {
            return redirect('/login');
        }

        return $user_id;
    }

}