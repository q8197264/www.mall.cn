<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppServices\Services\OrderService;
use App\AppServices\Services\AddressService;
use App\AppServices\Services\CartService;

class OrdersController extends Controller
{
    private $orderService;
    private $addressService;
    private $cartService;

    public function __construct(
                                OrderService $orderService,
                                AddressService $addressService,
                                CartService $cartService
    )
    {
        $this->orderService   = $orderService;
        $this->addressService = $addressService;
        $this->cartService    = $cartService;
    }

    /**
     * @param int $id
     *
     * @return view
     */
    public function detail()
    {
        $user_id = session('user_id');
        if (empty($user_id)) {
            return redirect('/login');
        }

        //get user address
        $address = $this->addressService->findListByUid($user_id);
        //-pay id
        //-shipping

        $res = [];
        //get cart goods list
        $res = $this->cartService->findListBySelected($user_id);
        //-invoice

        return view('frontend.order.detail', ['address'=>$address, 'data'=>$res]);
    }


    /**
     * create order
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create()
    {
        $user_id = session('user_id');

        if (empty($user_id)) {
            return redirect('/login');
        }

        //pay way from page
        //shipping way from page
        $data = $this->orderService->create($user_id);

        return view('frontend.order.end',['data'=>$data]);
    }
}
