<?php
namespace Services;


/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-28
 * Time: 01:02
 */
class Services
{
    private $config = [
        'Excel',
        'Action' => Report\Common\Action::class,
    ];

    public function __construct() {}

    //$obj->export()->excel()->save();



    public function __call($action='export', $argument)
    {

//        $findCalled = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
//        $called = array_pop($findCalled)['class'];
//        dd($called);
//        $resolve = explode('\\', $called);
//        dd($resolve);
//        new ;
        return call_user_func_array([new $this->config['Action'], $action], $argument);
    }
}