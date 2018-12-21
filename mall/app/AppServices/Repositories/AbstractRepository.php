<?php
namespace App\AppServices\Repositories;

/**
 * Repositories 接口.
 *
 * User: liuxiaoquan
 * Date: 2018-11-23
 * Time: 17:04
 */
class AbstractRepository
{
    /**
     * 检测是否符合用户格式
     *
     * @param $argv     检测对象格式
     *
     * @return bool
     */
    public static function isUsername($argv)
    {
        $regEx = '/^\w{3,20}$/';//英文
//        $regEx = '/^[a-zA-Z\x{4e00}-\x{9fa5}]{3,20}$/u'; //中英文
        return preg_match($regEx, $argv) ? $argv : false;
    }

    public static function isMail($argv)
    {
        $regEx = '/^[a-z0-9][a-z\.0-9-_]+@[a-z0-9-_]+(?:\.[a-z]{0,3}\.[a-z]{0,2}|\.[a-z]{0,3}|\.[a-z]{0,2})$/i';
        return preg_match($regEx, $argv) ? $argv : false;
    }

    public static function isMobile($argv)
    {
        $regEx = '/^(?:13|15|18|17)[0-9]{9}$/';
        return preg_match($regEx, $argv) ? $argv : false;
    }

    public static function checkUserType(string $name)
    {
        $data = [];
        switch ($name) {
            case self::isMobile($name):
                $type = 'phone';
                break;
            case self::isUsername($name):
                $type = 'username';
                break;
            case self::isMail($name):
                $type = 'email';
                break;
            default:
        }
        if (isset($type)) {
            $data = array($type=>$name);
        }

        return $data;
    }

    public static function isNickname(){}
}