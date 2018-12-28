<?php
namespace Services\Report\AbstractBase;

use Exception;
use ReflectionClass;
/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-28
 * Time: 20:22
 */
Abstract class AbstractCall
{
    final function __call($classname, $arguments=null)
    {
        if (null !== static::ActionNamespace) {//isset
            $class = static::ActionNamespace.'\\'.ucwords($classname);
        } else {
            throw new Exception(static::ActionNamespace.' is no exists',2);
        }

        //类构造函数接收不定量参数:如 new Excel(...) 类
        $reflect = new ReflectionClass($class);
        $obj = $reflect->NewInstanceArgs($arguments);
dd($class,$classname);
        return call_user_func_array([$obj, 'export'], $arguments);
    }
}