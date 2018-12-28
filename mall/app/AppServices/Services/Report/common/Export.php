<?php
/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-28
 * Time: 12:12
 */

namespace Services\Report\common;


class Export
{
    public function __construct($a, $b, $c)
    {
        var_dump($a,$b,$c);
    }

    public function save(string $path=null)
    {
        $res = call_user_func([$this->obj,'export'], $path);

        echo $path;
        return $res;
    }

    public function __call($classname, $arguments)
    {

        $reflect = ReflectionClass($classname);
        $this->obj = $reflect->NewInstanceArgs($arguments);

        return $this;
    }
}