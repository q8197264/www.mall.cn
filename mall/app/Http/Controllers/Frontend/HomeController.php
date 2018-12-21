<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\AppServices\Services\GoodsService;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\UserProvider;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-11-22
 * Time: 14:02
 */
class HomeController extends Controller
{
    protected $userService;

    public function __construct(GoodsService $goodsService)
    {
        $this->goodsService = $goodsService;
//        $this->middleware('auth');//web
    }

    public function index(Request $request)
    {
        $list = $this->goodsService->list(0);

//        \View::addExtension('html','php');
//        echo view()->file(public_path().'/frontend/index.html');
        //echo json_encode($list);
        return view('frontend.home', ['data'=>$list]);
    }


}