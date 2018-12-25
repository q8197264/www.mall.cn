<?php

namespace Libraries\Wechat;

use App\AppServices\Caches\Redis\Wechat\AuthorizeCache;

/**
 * get wechat authorize.
 *
 * User: sai
 * Date: 2018-12-24
 * Time: 18:21
 */
class Authorize extends Config
{
    protected static $openid;

    protected static $access_token;

    protected function initialize() {}

    public function auth()
    {
        return $this->getCode();
    }

    /**
     * get code : redirect back url
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getCode()
    {

        $code  = Request('code');
        $state = Request('state');
        if (empty($code)) {
            $url = str_replace(['{appid}', '{redirect_uri}', '{scope}'],
                [$this->appid, urlencode($this->redirect_uri), $this->scope],
                $this->askCodeUrl);
//            return redirect($url);
            header('Location:' . $url);
            exit;
        } else {
            $this->getToken($code, $state);
        }
    }

    /**
     * @param string $code
     * @param string $state
     *
     * @return \stdClass
     error: {"errcode":40029,"errmsg":"invalid code"}
     ok: { "access_token":"ACCESS_TOKEN",
        "expires_in":7200,
        "refresh_token":"REFRESH_TOKEN",
        "openid":"OPENID",
        "scope":"SCOPE" }
     */
    protected function getToken(string $code, string $state)
    {
        $url   = str_replace(['{appid}', '{secret}', '{code}'],
                                [$this->appid, $this->secret, $code],
                                $this->getTokenUrl);
        $token = file_get_contents($url);
        $token = json_decode($token);
        if (isset($token->access_token)) {
            static::$openid = $token->openid;
            static::$access_token = $token->access_token;

            //save access_token
            AuthorizeCache::saveToken($token->openid,
                ['access_token'=>$token->access_token,
                 'refresh_token'=>$token->refresh_token]);
        }

        return $token;
    }

    public function getOpenid()
    {
        return static::$openid;
    }

    public function getAccessToken()
    {
        return static::$access_token;
    }


    /**
     * check access_token
     *
     * @return array { "errcode":0,"errmsg":"ok"} || { "errcode":40003,"errmsg":"invalid openid"}
     */
    public function checkAccessToken(string $openid):array
    {
        $token = AuthorizeCache::getToken($openid);
        $url = str_replace(['{ACCESS_TOKEN}','{OPENID}'],
                            [$token['access_token'], $openid],
                            $this->checkAccessTokenUrl);
        $msg = file_get_contents($url);

        return (array) json_decode($msg);
    }

    /**
     * 刷新access_token
     *
     * @return array
     ok: { "access_token":"ACCESS_TOKEN",
                "expires_in":7200,
                "refresh_token":"REFRESH_TOKEN",
                "openid":"OPENID",
                "scope":"SCOPE" }
     error: {"errcode":40029,"errmsg":"invalid code"}
     */
    public function refreshToken(string $openid):array
    {
        $token = AuthorizeCache::getToken($openid);
        if (!empty($token['refresh_token'])) {

            //
            $url = str_replace(['{appid}', '{refresh_token}'],
                [$this->appid, $token['refresh_token']], $this->refreshTokenUrl);
            $token = file_get_contents($url);

            //save cache
            $token = json_decode($token);
            if ($token->refresh_token) {
                AuthorizeCache::saveToken($openid,['access_token'=>$token->access_token,
                                           'refresh_token'=>$token->refresh_token]);
            }
        } else {
            //refresh_token过期 重新获取
            $this->getCode();
        }

        return (array) $token;
    }

    /**
     *  get user info
     *
     * @return array
     * error:
     * {"errcode":40003,"errmsg":" invalid openid "}
        ok:
       {    "openid":" OPENID",
            " nickname": NICKNAME,
            "sex":"1",
            "province":"PROVINCE"
            "city":"CITY",
            "country":"COUNTRY",
            "headimgurl":    "http://thirdwx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46",
            "privilege":[ "PRIVILEGE1" "PRIVILEGE2"     ],
            "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
       }
     */
    public function getUserInfo(string $openid):array
    {
        $token = AuthorizeCache::getToken($openid);

        if (!empty($token['access_token']) && !empty($openid)) {
            $url = str_replace(['{ACCESS_TOKEN}','{OPENID}'],
                [$token['access_token'], $openid],
                $this->userinfoUrl);

            $userinfo = file_get_contents($url);

            $userinfo = (array) json_decode($userinfo);
        }

        return isset($userinfo)?$userinfo:[];
    }


}