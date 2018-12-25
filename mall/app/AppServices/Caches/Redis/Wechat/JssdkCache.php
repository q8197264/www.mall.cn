<?php

namespace App\AppServices\Caches\Redis\Wechat;

use Illuminate\Support\Facades\Redis;
use App\AppServices\Caches\Redis\Config;

/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-25
 * Time: 12:29
 */
class JssdkCache extends Config
{
    public static function saveToken(string $token, int $expire=0)
    {
        $nil = Redis::set(self::$wechat_token_string, $token);

        $expire = $expire > 0 ? $expire : self::$wechat_token_string_expire;
        Redis::expire(self::$wechat_token_string, $expire);

        return $nil->getPayload();
    }

    public static function getToken()
    {
        $token = Redis::get(self::$wechat_token_hash);

        return $token;
    }

    public static function saveTicket(string $ticket, int $expire=0)
    {
        $nil = Redis::set(self::$wechat_ticket_string, $ticket);
        $expire = $expire > 0 ? $expire : self::$wechat_ticket_string_expire;
        Redis::expire(self::$wechat_ticket_string, $expire);

        return $nil->getPayload();
    }

    public static function getTicket()
    {
        $ticket = Redis::get(self::$wechat_ticket_string);

        return $ticket;
    }
}