<?php
/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-27
 * Time: 03:20
 */

namespace App\Http\Controllers\Frontend;

use Libraries\Wechat\Message\Response;

class WechatServerFirstConnectingVerify
{
    public function index()
    {
        (new Response())->Index();
        exit;//微信服务器配置连接
    }
}