<?php
namespace App\AppServices\Libraries\Wechat\Message;

/**
 * Message template.
 *
 * User: sai
 * Date: 2018-12-27
 * Time: 11:22
 */
class Template
{
    /**
     * 注册成功 消息模板
     *
     * @param $openid
     * @param $username
     *
     * @return array
     */
    public static function registerSuccess($openid, $username)
    {
        $template = [
            "touser"      => "$openid",
            "template_id" => "JXhQjlGpNjVYB8irDEe_dmy-rdzhzrTQ8PrLZF5ADNw",
            'url'         => '跳转地址',
            'topcolor'    => '#ccc',
            'data'        => [
                'first'    => [
                    'value' => urlencode('您已成功在本站注册名为XX的帐号'),
                    'color' => "#743A3A",
                ],
                'username' => [
                    'value' => urlencode($username),
                    'color' => '#FF0000'
                ],
                'remark'   => [
                    'value' => urlencode('如果您对以上信息有任何疑问，请直接在平台上回复您的问题即可，或拨打客服电话4001021789。再次感谢您的惠顾！'),
                    'color' => '#FF0000'
                ],
            ]
        ];

        return $template;
    }

    public static function ask($openid, $username, $ask, $remark)
    {
        $template = [
            'touser' => $openid,
            'template_id' => 'Oblr5uXH_fS79gMC8E0mYz0CpUAHnJtdvAC3PWABrsk',//模板ID
            'url' => 'https://www.liminghulian.com/course/3/lesson/list', //点击详情后的URL可以动态定义
            'topcolor'=>"#FF0000",
            'data' =>
                [
                    'tip' =>
                        [
                            'value' => '您好!有访客访给您留言了。',
                            'color' => '#173177'
                        ],
                    'user' =>
                        [
                            'value' => urlencode($username),//'张三',
                            'color' => '#FF0000'
                        ],

                    'ask' =>
                        [
                            'value' => urlencode($ask),//'您好,非常关注黎明互联,有没有关于支付宝的视频教程?',
                            'color' => '#173177'
                        ],
                    'remark' =>
                        [
                            'value' => urlencode($remark),//'该用户已注册12天',
                            'color' => 'blue'
                        ]
                ]
        ];

        return $template;
    }

    /*
     * 下单成功通知模板
     *
     * openid:微信唯一标识
     * orderSn:订单号
     * goods_name:商品名称
     * goods_num:商品数量
     * allMoney:总价格
     */
    public static function orderSuccess($openid, $orderSn, $amount, $paymode, $goods_name = null, $goods_num = null)
    {
        $template = [
            "touser"      => "$openid",
            "template_id" => "GEMR6sQyRoMWFWZTCl9bRBmdnMC93ipK6KniFRstzYk",
            'url'         => '跳转地址',
            'topcolor'    => '#ccc',
            'data'        => [
                'tip'    => [
                    'value' => urlencode('亲，您的订单已创建成功，我们会立即为您备货，并在第一时间内为您安排专人免费送货到家！订单详情如下'),
                    'color' => "#743A3A",
                ],
                'order_sn' => [
                    'value' => urlencode($orderSn),
//                    'color' => '#FF0000'
                ],
                'goods_name' => [
                    'value' => urlencode($goods_name),
                    'color' => '#FF0000'
                ],
                'goods_num' => [
                    'value' => urlencode($goods_num),
                    'color' => '#FF0000'
                ],
                'amount' => [
                    'value' => urlencode($amount),
                    'color' => '#FF0000'
                ],
                'paymode' => [
                    'value' => urlencode($paymode),
//                    'color' => '#FF0000'
                ],
                'remark'   => [
                    'value' => urlencode('如果您对以上信息有任何疑问，请直接在平台上回复您的问题即可，或拨打客服电话4001021789。再次感谢您的惠顾！'),
//                    'color' => '#FF0000'
                ],
            ]
        ];
        
        return $template;
    }
}