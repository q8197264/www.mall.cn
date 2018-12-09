<?php
namespace App\Services\User;

/**
 * 帐号检测类.
 * User: liuxiaoquan
 * Date: 2018-12-07
 * Time: 18:43
 */
class Check
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
        $regEx = '/^\w{3,16}$/';

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

    public static function checkName(string $name)
    {
        switch ($name) {
            case self::isMobile($name):
                $type = 'phone';
                break;
            case self::isUsername($name):
                $type = 'uname';
                break;
            case self::isMail($name):
                $type = 'email';
                break;
            default:
                $type = '格式错误';
                break;
        }

        return array($type=>$name);
    }

    public static function isNickname(){}
}