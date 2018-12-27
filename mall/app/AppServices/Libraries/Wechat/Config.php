<?php
namespace Libraries\Wechat;

use App\AppServices\Caches\Redis\Wechat\JssdkCache;
use Libraries\Wechat\Jssdk\JSSDK;

/**
 * Wechat Config.
 *
 * User: sai
 * Date: 2018-12-24
 * Time: 19:04
 */
abstract class Config
{
    protected $appid  = 'wx82bd2ac6d1a94af9';
    protected $secret = '3b2c9626485f734c086a707ff41836db';


    /*** auth 2.0 授权接口 **/
    protected $scope = 'snsapi_base';//snsapi_userinfo

    //1.get code
    protected $askCodeUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={appid}&redirect_uri={redirect_uri}&response_type=code&scope={scope}&state=YQJ#wechat_redirect";

    //2.get token
    protected $getTokenUrl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={appid}&secret={secret}&code={code}&grant_type=authorization_code";

    //refresh token
    protected $refreshTokenUrl = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid={appid}&grant_type=refresh_token&refresh_token={refresh_token}";

    //get userinfo
    protected $userinfoUrl = "https://api.weixin.qq.com/sns/userinfo?access_token={ACCESS_TOKEN}&openid={OPENID}&lang=zh_CN";

    //check access_token
    protected $checkAccessTokenUrl = "https://api.weixin.qq.com/sns/auth?access_token={ACCESS_TOKEN}&openid={OPENID}";

    /** Jssdk 接口 **/
    protected $getAccessTokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={APPID}&secret={SECRET}";
    // 如果是企业号用以下URL获取access_token
    // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid={APPID}&corpsecret={SECRET}";

    //get ticket
    protected $getTicketUrl = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token={ACCESS_TOKEN}";

    //download images
    protected $downImageUrl = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token={ACCESS_TOKEN}&media_id={MEDIA_ID}";


    protected $redirect_uri;

    protected $saverImageDir;

    public function __construct()
    {
        if (isset($_SERVER['HTTP_HOST'])) {
            $this->redirect_uri = isset($_SERVER['SERVER_PROTOCOL'][0])
                ?explode('/', $_SERVER['SERVER_PROTOCOL'])[0]
                :'http' .'://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }


        $this->saverImageDir = dirname(dirname(dirname(dirname(
            dirname(dirname(__FILE__)))))).'/mall/public';

        $this->initialize();
    }

    abstract protected function initialize();

    //获取accesstoken
    protected function getAccessToken()
    {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $access_token = JssdkCache::getToken();
        if (empty($access_token)) {
            $url = str_replace(['{APPID}', '{SECRET}'], [$this->appid, $this->secret], $this->getAccessTokenUrl);
            $res = json_decode($this->httpGet($url));
            if (isset($res->access_token)) {
                $access_token = $res->access_token;
                JssdkCache::saveToken($access_token);
            }
        }

        return $access_token;
    }

    protected function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);

        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面3行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        //这是根据http://curl.haxx.se/ca/cacert.pem 下载的证书，添加这句话之后就运行正常了
        curl_setopt($curl, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');

        //CURLOPT_SSL_VERIFYHOST 设置为 1 是检查服务器SSL证书中是否存在一个公用名(common name)。译者注：公用名(Common Name)一般来讲就是填写你将要申请SSL证书的域名 (domain)或子域名(sub domain)。 设置成 2，会检查公用名是否存在，并且是否与提供的主机名匹配。 在生产环境中，这个值应该是 2（默认值）。
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);


        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    /**
     * 通过CURL发送数据
     * @param $url 请求的URL地址
     * @param $data 发送的数据
     * return 请求结果
     */
    protected function curlPost($url,$data)
    {
        $ch = curl_init();
        $params[CURLOPT_URL] = $url;    //请求url地址
        $params[CURLOPT_HEADER] = FALSE; //是否返回响应头信息
        $params[CURLOPT_SSL_VERIFYPEER] = false;
        $params[CURLOPT_SSL_VERIFYHOST] = false;
        $params[CURLOPT_RETURNTRANSFER] = true; //是否将结果返回
        $params[CURLOPT_POST] = true;
        $params[CURLOPT_POSTFIELDS] = $data;
        curl_setopt_array($ch, $params); //传入curl参数
        $res = curl_exec($ch); //执行
        curl_close($ch); //关闭连接

        return $res;
    }

    protected function httpFile(string $url, string $file)
    {
        $fp = fopen($file, "w");

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);

        fclose($fp);

        return $output;
    }

    //----- 以下方法未使用 为参考
    /**
     * debug ...
     *
     * @return bool|string
     */
    protected function httpPost()
    {
        $type  = "image";  //声明上传的素材类型，这里为image
        $token = get_access_token();//调用接口需要获取token,这里使用一个封装好的调取access_token的函数
        $url   = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=" . $token . "&type=" . $type;
        //这里是请求地址，token和素材类型通过get方式传递
        $file_path = dirname(__FILE__) . "/pro.jpg";
        //这里声明文件的路径，使用绝对路径
        $file_data = ['media' => '@' . $file_path];
        //传递的数组，方式一：使用'@'符号加上文件的绝对路径来指引文件。这种方式适合PHP5.5之前的版本，
        $file_data = ["media" => new \CURLFile($file_path)];
        //传递的数组，方式二：从PHP5.5版本以后，引入了新的CURLFile 类来指向文件，参数传入的也是绝对路径
        $ch = curl_init();
        //初始化一个新的会话，返回一个cURL句柄，供curl_setopt(), curl_exec()和curl_close() 函数使用。
        curl_setopt($ch, CURLOPT_URL, $url);
        //需要获取的URL地址，也可以在curl_init()函数中设置。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //使用PHP curl获取页面内容或提交数据，有时候希望返回的内容作为变量储存，
        //而不是直接输出。这个时候就必需设置curl的CURLOPT_RETURNTRANSFER选项为1或true
        curl_setopt($ch, CURLOPT_POST, 1);
        //发送一个POST请求
        curl_setopt($ch, CURLOPT_POSTFIELDS, $file_data);
        //传递一个关联数组，生成multipart/form-data的POST请求
        $output = curl_exec($ch);//发送请求获取结果
        curl_close($ch);//关闭会话

        return $output;//返回结果
    }
}