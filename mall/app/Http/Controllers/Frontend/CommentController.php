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

    /**
     * kind of goods with different status
     */
    public function index() {}

    /**
     * 待评论商品list
     *
     * @param int $order_id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function link(int $order_id)
    {
        $this->isLogin();

        $list = $this->commentService->getGoodsWithWaitComment($order_id);

        return view('frontend.comment.link', ['list'=>$list]);
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
        $this->isLogin();

        $list = $this->commentService->getGoodsWithWaitComment($order_id, $sku_id);

        $jssdk = new JSSDK();
        $config = $jssdk->GetSignPackage();

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
        session()->put('user_id',77);
        $parameters['user_id'] = $this->isLogin();
        $media_ids = $request->input('mediaIds');
        if (!empty($media_ids) && is_array($media_ids)) {
            $parameters['media_ids'] = array_unique($media_ids);
        }
        $parameters['order_no'] = $request->input('osn');
        $parameters['order_id'] = $request->input('oid');
        $parameters['sku_id'] = $request->input('kid');
        $parameters['spu_id'] = $request->input('sid');
        $parameters['comment'] = $request->input('comment');

        $nil = $this->commentService->save($parameters);

        echo json_encode($nil);
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