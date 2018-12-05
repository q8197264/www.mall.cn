<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\UserService;
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

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        echo '<pre>';
        echo __METHOD__,"\n";
        $this->userService->getAllUsers();
//        return view('frontend/index',compact('title','list','info','email'));
//        return view('users.login');
//        \View::addExtension('html','php');
//        echo view()->file(public_path().'/frontend/index.html');
    }

    
}