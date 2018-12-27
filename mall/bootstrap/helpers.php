<?php
/**
 * My helper function.
 * User: liuxiaoquan
 * Date: 2018-11-22
 * Time: 13:46
 */
function objectToArray($object) :array
{
    $array = array_walk_recursive($object, function ($v, $K) {
        print_r($v);
        return (array) $v;
    });

    return $array;
}