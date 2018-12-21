<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth.admin:admin');
    }

    /**
     * 显示后台管理模板首页
     */
    public function index(Request $request)
    {
        echo $request->session()->get('user_id');
        echo $request->session()->get('username');
        //dd('用户名：'.auth('admin')->user()->name);
        echo '...<p>';
        if(auth()->guard('admin')->guest()){
            echo 'true';
        }
        echo '</p>...';

        return view('admin.index');
    }
}
