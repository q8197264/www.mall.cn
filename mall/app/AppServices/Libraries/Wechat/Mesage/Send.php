<?php
namespace Libraries\Wechat\Message;

use App\AppServices\Caches\Redis\Wechat\JssdkCache;
use Libraries\Wechat\Config;

/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-27
 * Time: 04:38
 */
class Send extends Config
{
    protected $token;

    protected function initialize()
    {
        // TODO: Implement initialize() method.
        $this->token = JssdkCache::getToken();
    }

    //单发消息
    public function send($fakeid,$content){

        $url = 'https://mp.weixin.qq.com/cgi-bin/singlesend?t=ajax-response&lang=zh_CN';
        $this->send_data = array(
            'type' => 1,
            'content' => $content,
            'error' => 'false',
            'tofakeid' => $fakeid,
            'token' => $this->token,
            'ajax' => 1,
        );
        $this->referer = 'https://mp.weixin.qq.com/cgi-bin/singlemsgpage?token='.$this->token.'&fromfakeid='.$fakeid.'&msgid=&source=&count=20&t=wxm-singlechat&lang=zh_CN';

        return $this->curlPost($url);
    }

    //群发消息
    public function sendMessage($content='',$userId='') {
        if(is_array($userId) && !empty($userId)){
            foreach($userId as $v){
                $json = json_decode($this->send($v,$content));
                if($json->ret!=0){
                    $errUser[] = $v;
                }
            }
        }else{
            foreach($this->userFakeid as $v){
                $json = json_decode($this->send($v['fakeid'],$content));
                if($json->ret!=0){
                    $errUser[] = $v['fakeid'];
                }
            }
        }

        //共发送用户数
        $count = count($this->userFakeid);
        //发送失败用户数
        $errCount = count($errUser);
        //发送成功用户数
        $succeCount = $count-$errCount;

        $data = array(
            'status'=>0,
            'count'=>$count,
            'succeCount'=>$succeCount,
            'errCount'=>$errCount,
            'errUser'=>$errUser
        );

        return json_encode($data);
    }

}