<?php
namespace Services;


use Exception;

/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-28
 * Time: 01:02
 */
class Services
{
    //此处可单独做为redis缓存配置独立出来(定期落地备份)，多人协同
    private $config = [
        'Excel'  => Report\Excel::class,

        'Export' => Report\Action\Action::class,
        'Import' => Report\Action\Action::class,


    ];

    public function __construct() {}

    public function __call($target, $argument)
    {
        $target = ucwords($target);
//        $findCalled = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
//        $called = array_pop($findCalled)['class'];
//        dd($called);
//        $resolve = explode('\\', $called);
//        dd($resolve);
        try{
            if (empty($this->config[$target])) {
                $this->config[$target] = 'Services\\'.$target.'\\'.$target;
            }
            if (!class_exists($this->config[$target])) {
                throw new Exception('接口类不存在',1);
            }
            $target = new $this->config[$target];
//            call_user_func_array([$target, 'initialize'], $argument);
        }catch(\Exception $e){
            $res['errcode'] = $e->getCode();
            $res['msg'] = $e->getMessage();
        }

        return $target;
    }
}