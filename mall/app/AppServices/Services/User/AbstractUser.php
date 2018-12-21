<?php
namespace App\AppServices\Services\User;

use Illuminate\Container\Container as App;

/**
 * 用户公共接口.
 * User: liuxiaoquan
 * Date: 2018-11-23
 * Time: 14:18
 */
abstract class AbstractUser
{
    protected static $userRespository;

    final function __construct(App $app)
    {
        if (empty(static::getUserRespository())) {
            static::$userRespository = $app->make('App\AppServices\Repositories\User\UserRepository');
        }

        $this->initialize();
    }

    abstract protected function initialize();

    protected static function getUserRespository()
    {
        return static::$userRespository;
    }


}