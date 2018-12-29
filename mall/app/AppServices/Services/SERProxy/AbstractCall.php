<?php
namespace Services\SERProxy;

use Exception;
use Illuminate\Container\Container as App;
/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-28
 * Time: 20:22
 */
Abstract class AbstractCall
{
    final function __call($classname, $arguments = null)
    {
        if (!empty(static::$ActionNamespace)) {
            $classname = static::$ActionNamespace . '\\' . ucwords($classname);
        } else {
            $classname = static::class;
        }
        $obj = (new App)->make($classname);

        return $obj;
    }
}