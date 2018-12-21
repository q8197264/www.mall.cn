<?php
namespace App\Http\Controllers\Frontend;

use App\AppServices\Services\AddressService;
use Illuminate\Http\Request;

/**
 * order .
 *
 * User: sai
 * Date: 2018-12-19
 * Time: 21:40
 */
class AddressController
{
    protected $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    /**
     * check login
     *
     * @return int or redirect
     */
    private function checkLogin()
    {
        $user_id = session('user_id');
        if (empty($user_id)) {
            return redirect('/login');
        }

        return $user_id;
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function show()
    {
        $uid = $this->checkLogin();
        $res = [];
        if (isset($uid)) {
            $res = $this->addressService->findListByUid($uid, 5);
        }

        return view('frontend.address.add', ['data'=>$res]);
    }

    /**
     * add data row to address
     *
     * @param string $address       地址名
     * @param int    $int
     *
     * @return bool|void
     */
    public function add()
    {
        $user_id = $this->checkLogin();
        $param = Request(['name','tel','phone','province','city','district','address']);
        $param['user_id'] = $user_id;
        $bool = false;
        if (isset($user_id)) {
            $bool = $this->addressService->add($param);
        }

        return $bool;
    }

    /**
     * set default address
     *
     * @return bool
     */
    public function setDefault(Request $request)
    {
        $user_id = $this->checkLogin();
        $id = $request->intput('id');
        $bool = false;
        if (isset($user_id)) {
            $bool = $this->addressService->setDefault($id, $user_id);
        }

        echo json_encode($bool);
    }

    /**
     * edit address
     */
    public function edit()
    {
        $user_id = $this->checkLogin();
        $parameters = Request([
            'name',
            'tel',
            'phone',
            'province',
            'city',
            'district',
            'address',
        ]);
        $parameters['user_id'] = $user_id;
        $bool = $this->addressService->edit($parameters);

        echo json_encode($bool);
    }

    /**
     * delete address
     *
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $user_id = $this->checkLogin();
        $id = $request->input('id');

        $bool = $this->addressService->del($id, $user_id);

        echo json_encode($bool);
    }
}