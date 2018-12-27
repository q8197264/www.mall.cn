<?php
namespace Libraries\Wechat\Message;


//实例化Wechat类
//$wechat = new Wechat();
//调用index方法
//$wechat->index();
/**
 * 消息与回复.
 *
 * User: sai
 * Date: 2018-12-24
 * Time: 18:06
 */
class Response
{

    public $token = 'mall';

    public $echostr;//用于验证的token

    public $FromUserName;//消息发送人

    public $ToUserName;//消息接收人

    public $MsgType;//消息类型

    public $Content;//消息内容

    public $Event; //事件类型

    public $xmlInfo; //接收到的MXL格式消息

    public function __construct()
    {
        $this->echostr = $_GET['echostr']??null;
    }

    public function Index()
    {
        if (!empty($this->echostr)) {
            $this->checkToken();
        } else {
            $this->responseMsg();
        }
    }

    /**
     * 服务器连接配置
     *
     * 验证token
     */
    public function checkToken()
    {
        //获取本地定义token
        $token = $this->token;
        //接受请求信息
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce     = $_GET['nonce'];
        //将接受的参数放在数组中
        $verify_arr = [$token, $timestamp, $nonce];
        //对数进行排序
        sort($verify_arr, SORT_REGULAR);
        //将数组转化成字符串
        $verify_str = implode('', $verify_arr);
        //对字符串进行sha1加密
        $verify_sha1 = sha1($verify_str);
        //将加密后的字符串和signature进行对比
        if ($verify_sha1 != $signature) {
            //对比失败返回no
            echo 'no';
            die;
        }
        //对比成功返回接受到的$echostr
        echo $this->echostr;
        die;
    }


    //接收信息&&判断类型
    public function responseMsg()
    {

        //接收请求信息
        $this->receiveInfo();
        //判断类型
        switch ($this->MsgType) {
            //文本信息调用返回文本信息回复方法
            case "text":
                $this->returnText();
                break;
            //事件调用事件返回方法
            case "event":
                $this->returnEvent();
                break;
        }
    }

    //对事件进行判断
    public function returnEvent()
    {
        //对事件进行判断
        switch ($this->Event) {
            //关注事件
            case "subscribe" :
                $this->returnInfo("这是我的一个测试号，这里有机器人，可以和它聊天。");
                break;
            //用户当前所在地理位置（经度、纬度）
            case "LOCATION" :
                $this->returnLOCATION();
                break;
        }
    }

    //获取当前用户经纬度，并调用高德地图回复地址
    public function returnLOCATION()
    {
        $Longitude = $this->xmlInfo->Longitude;//经度
        $Latitude  = $this->xmlInfo->Latitude;//伟度
        $gaode     = 'ba2cd75562d3ae5beccf20f8a12d6a55';//高德key
        //高德获取地理位置接口路径
        $url  = 'http://restapi.amap.com/v3/geocode/regeo?output=json&location=' . $Longitude . ',' . $Latitude . '&key=' . $gaode;
        $info = file_get_contents($url);
        $data = json_decode($info, true);
        return $this->returnInfo("您的地址为：" . $data['regeocode']['formatted_address']);
    }

    //判断用户输入文本信息
    public function returnText()
    {
        //判断用户输入信息
        switch ($this->Content) {
            case "测试1" :
                $this->returnInfo("回复测试1");
                break;
            case "测试2" :
                $this->returnInfo("回复测试2");
                break;
            default:
                $this->returnRobot($this->Content);
                break;
        }
    }

    public function returnRobot($content)
    {
        $url  = 'http://www.tuling123.com/openapi/api';
        $data = http_build_query(["key" => "6340fcf9b38e45279c09b8581d0760dd", "info" => $content[0]]);
        $res  = $this->CURL($url, $data, false);
        $info = json_decode($res, true);
        if ($info['code'] == 100000) {
            $this->returnInfo($info['text']);
        } else {
            $this->returnInfo("机器人接口暂时无法使用");
        }
    }

    public function CURL($url, $data, $https = true)
    {
        $ch = curl_init();
// curl_setopt($ch,CURLOPT_SAFE_UPLOAD,false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $https);
// post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    //回复文本信息
    public function returnInfo($content)
    {
        //文本信息回复格式
        $str = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[text]]></MsgType>
        <Content><![CDATA[%s]]></Content>
        </xml>";
        //将占位符替换成具体信息，并输出字符串
        echo $backInfo = sprintf($str, $this->FromUserName, $this->ToUserName, time(), $content);
    }

    //获取数据
    public function receiveInfo()
    {
        $xmlInfo            = file_get_contents("php://input");
        $this->xmlInfo      = simplexml_load_string($xmlInfo, 'SimpleXMLElement', LIBXML_NOCDATA);
        $this->FromUserName = $this->xmlInfo->FromUserName;
        $this->ToUserName   = $this->xmlInfo->ToUserName;
        $this->MsgType      = $this->xmlInfo->MsgType;
        $this->Content      = (array)$this->xmlInfo->Content;
        $this->Event        = $this->xmlInfo->Event;
    }
}
