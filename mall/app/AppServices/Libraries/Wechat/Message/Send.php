<?php
namespace Libraries\Wechat\Message;

use App\AppServices\Libraries\Wechat\Message\Template;
use Libraries\Wechat\Config;

/**
 * Send message.
 * User: sai
 * Date: 2018-12-27
 * Time: 04:38
 */
class Send extends Config
{
    protected $callTemplate;

    //请求模板消息的地址
    const TEMP_URL = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=';

    protected function initialize()
    {
        // TODO: Implement initialize() method.
    }

    /**
     *  选择模板
     *
     * @param string $template
     *
     * @return $this
     */
    public function template($template='orderSuccess')
    {
        $this->callTemplate = $template;

        return $this;
    }

    /**
     * 微信模板消息发送
     * @param $openid 接收用户的openid
     * return 发送结果
     */
    public function send()
    {
        $args = func_get_args();

        $template = call_user_func_array([new Template, $this->callTemplate], $args);

        $tokens = $this->getAccessToken();

        $url = self::TEMP_URL . $tokens;
        $json_template = json_encode($template,JSON_UNESCAPED_UNICODE);

        return $this->curlPost($url, urldecode($json_template));
    }
}