<?php
namespace Services\Report\Common;


/**
 * proxy mode.
 *
 * User: sai
 * Date: 2018-12-28
 * Time: 12:13
 */

class Action
{
    protected $config;

    public function __construct()
    {
        $this->config = [];
    }

    //export(array)->excel
    public function export(string $start, string $end)
    {
        $args = func_get_args();

        echo 'action=export';
        $reflect =new \ReflectionClass('Export');
        $export = $reflect->NewInstanceArags($this->config);
dd(1);
        return call_user_func_array([$export,'export']);
    }

    public function import()
    {
        echo 'action=import';

        return $this;
    }

    public function __call($classname, $arguments=null)
    {
        // TODO: Implement __call() method.

        //类构造函数接收不定量参数:如 new Excel(...) 类
        $reflect = new ReflectionClass($classname);
        $obj = $reflect->NewInstanceArgs($arguments);

        return call_user_func_array([$obj, 'export'], $arguments);
    }
}