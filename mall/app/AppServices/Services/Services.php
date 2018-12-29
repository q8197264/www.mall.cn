<?php

namespace Services;

use Illuminate\Container\Container as App;
use Exception;

/**
 * 路由到对应接口.
 *
 * User: sai
 * Date: 2018-12-28
 * Time: 01:02
 */
class Services
{
    protected $app;

    //此处可单独做为redis缓存配置独立出来(定期落地备份)，多人协同
    private $config = [
        'Report' => Report\Report::class,
    ];

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function __call($target, $argument)
    {
        $target = ucwords($target);
        try {
            if (empty($this->config[$target])) {
                $this->config[$target] = 'Services\\' . $target . '\\' . $target;
            }
            if (!class_exists($this->config[$target])) {
                throw new Exception('接口类不存在', 1);
            }

            $target = $this->app->make($this->config[$target]);
        } catch (Exception $e) {
            $target['errcode'] = $e->getCode();
            $target['msg']     = $e->getMessage();
        }

        return $target;
    }


}