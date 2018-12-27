<?php

namespace Libraries\Wechat\Jssdk;

use App\AppServices\Caches\Redis\Wechat\JssdkCache;
use Libraries\Wechat\Config;

class JSSDK extends Config
{
    public function initialize() { }

    public function getSignPackage()
    {
        $jsapiTicket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url      = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr  = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = [
            "appid"     => $this->appid,
            "noncestr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawstring" => $string
        ];
        return $signPackage;
    }

    private function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str   = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket()
    {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $ticket = JssdkCache::getTicket();
        if (empty($ticket)) {
            $accessToken = $this->getAccessToken();

            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
            if (isset($res->ticket)) {
                $ticket = $res->ticket;
                JssdkCache::saveTicket($res->ticket);
            }
        }

        return $ticket;
    }


    /**
     * download file to local
     *
     * @param string $mediaId
     *
     * @return string
     */
    public function downloadImage(string $mediaId):string
    {
        $token = $this->getAccessToken();

        //定义保存路径
        $homedir = '/images/goods_comment/'.date('Y_m_d'). '/';
        $path = $this->saverImageDir.$homedir;
        $filename = time() . rand() . ".jpg";
        $file = $path.$filename;

        //数据库存的路径
        $DBpath = $homedir.$filename;

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
            chmod($path, 0777);
        }
        $url  = str_replace(['{ACCESS_TOKEN}', '{MEDIA_ID}'], [$token, $mediaId], $this->downImageUrl);
        $bool  = $this->httpFile($url, $file);
        $bool? $DBpath : '';

        return $bool;
    }

    //获取图片路径
    public function getWechatImageUrl(string $mediaId)
    {
        $token = $this->getAccessToken();
        $url  = str_replace(['{ACCESS_TOKEN}', '{MEDIA_ID}'], [$token, $mediaId], $this->downImageUrl);

        return $url;
    }

}

