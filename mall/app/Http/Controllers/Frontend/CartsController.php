<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\AppServices\Services\CartService;

class CartsController extends Controller
{
    protected $cartService;

    //
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * get cart list
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $uid = $request->session()->get('user_id');
        $list = [];
        if (isset($uid)) {
            $list = $this->cartService->findCartList($uid);
        }

        return view('frontend.cart.cart', ['data'=>$list]);

    }

    /**
     * @param Request $request
     */
    public function add(Request $request)
    {
        $data = Request(['spu_id','sku_id','shop_id','number']);
        $user_id = session('user_id');
        $bool = false;
        if (!empty($user_id)) {
            //如要实现登陆前商品加入购物车，cookie有效期内登陆，登陆前加入购物车的商品便自动移入到登陆后用户的购物车
            //需设计购物车表两个字段实现状态交换：userid, session_id
            $data = array_merge(['user_id' => $user_id], $data);

            //添加到购物车
            $bool = call_user_func_array(array($this->cartService, 'add'), $data);
        }

        echo $bool;
        return redirect('/carts');
    }

    /**
     * Is the product selected
     *
     * @param Request $request
     */
    public function selected(Request $request)
    {
        $cart_id = $request->input('id');
        $isChecked = strcasecmp($request->input('checked'),'true')?false:true;
        $bool = $this->cartService->selected($cart_id, $isChecked);

        echo json_encode($bool);
    }

    /**
     * 更改库存
     */
    public function edit(Request $request)
    {
        $id   = $request->input('id');
        $incr = $request->input('incr');

        $bool = $this->cartService->modify($id, $incr);

        echo json_encode($bool);
    }

    /**
     * delete cart data
     *
     * @param Request $request
     */
    public function del(Request $request)
    {
        $id = $request->input('id');

        $bool = $this->cartService->remove($id);

        echo json_encode($bool);
    }

}
