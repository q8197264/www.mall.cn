<?php
namespace App\AppServices\Caches\Redis\Wechat;

use Illuminate\Support\Facades\Redis;
use App\AppServices\Caches\Redis\Config;

/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-24
 * Time: 20:14
 */
class AuthorizeCache extends Config
{
    public function __construct()
    {
        //Redis::select(static::$wechat_database);
    }

    public static function saveToken(string $openid, array $token)
    {
        $res = Redis::hmset(self::$wechat_token_hash.$openid, $token);

        return $res->getPayload();
    }

    public static function getToken(string $openid)
    {
        $hash = Redis::hgetall(self::$wechat_token_hash.$openid);

        return $hash;
    }
}