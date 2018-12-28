<?php
/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-28
 * Time: 12:12
 */

namespace Services\Report\Action;

use ReflectionClass;

class Export
{
    private $format = [
        'excel'=> \Services\Report\Excel::class,
        'csv'=>\Services\Report\CSV::class,
    ];

    public function __construct($from='', $to='', $chunk=null)
    {
    }

    public function export(){

    }

    public function save(string $path=null)
    {
        //select db

        $res = call_user_func([$this->target,'export'], $path);

        echo $path;
        return $res;
    }

    public function __call($classname, $arguments)
    {
        $reflect = new ReflectionClass($this->format[$classname]);
        $this->target = $reflect->newInstanceArgs($arguments);

        return $this;
    }
}