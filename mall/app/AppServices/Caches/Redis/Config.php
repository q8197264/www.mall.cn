<?php
namespace App\AppServices\Caches\Redis;

/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-24
 * Time: 20:16
 */
class Config
{
    protected static $wechat_database = 1;//数据库号

    //auth2.0
    protected static $wechat_token_hash = 'wechat:auth:token:hash:';//openid:{access_token:'',refresh_token:''}30天
    protected static $wechat_token_expire = 29*24*60*60;

    //jssdk
    protected static $wechat_token_string = 'wechat:token:string';
    protected static $wechat_ticket_string = 'wechat:ticket:string';
    protected static $wechat_token_string_expire = 7000;
    protected static $wechat_ticket_string_expire = 7000;//7200s
}