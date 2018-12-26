<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\AppServices\Services\CommentService;
use App\AppServices\Services\OrderService;

use Services\FileSystemService;
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

    protected $fileSystemService;

    public function __construct(CommentService $commentService,
                                OrderService $orderService,
                                FileSystemService $fileSystemService)
    {
        $this->commentService = $commentService;
        $this->orderService = $orderService;

        $this->fileSystemService = $fileSystemService;
    }

    public function test(Request $request)
    {
//        $file = '/www/www.mall.cn/mall/public/images/goods_comment/2018_12_25/15457467731759596053.jpg';
        $list = $this->fileSystemService->listFile();
//        echo json_encode($request->file('image'));

        // 判断文件是否上传以及获取的文件是否是个有效的实例对象
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            return $this->fileSystemService->uploadFile($request->file('image'));

            exit ("请上传文件！");
            //$media_id = $request->input('mediaIds');
//            $nil = $this->fileSystemService->upload($order_id, $media_id, $user_id);
        }
        $jssdk = new JSSDK();
        $config = $jssdk->GetSignPackage();
        return view('frontend.comment.test',['list'=>$list,'config'=>$config]);
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
        $this->isLogin();

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

        $media_id = $request->input('mediaIds');

        //$res = (new JSSDK())->downloadImage($MEDIA_ID);
        echo json_encode($media_id);
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
    protected function isLogin()
    {
        $user_id = session('user_id');
        if (empty($user_id)) {
            return redirect('login');
        }

        return $user_id;
    }

}