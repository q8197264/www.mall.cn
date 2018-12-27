<?php
namespace App\AppServices\Services\Administrator;

use Illuminate\Container\Container as App;

/**
 * 用户公共接口.
 * User: liuxiaoquan
 * Date: 2018-11-23
 * Time: 14:18
 */
abstract class AbstractAdministrator
{
    protected static $administratorRepository;

    final function __construct(App $app)
    {
        if (empty(static::getAdministratorRespository())) {
            static::$administratorRepository = $app
                ->make('App\AppServices\Repositories\Administrator\AdministratorRepository');
        }

        $this->initialize();
    }

    abstract protected function initialize();

    /**
     * Query user model
     *
     * @return mixed
     */
    protected static function getAdministratorRespository()
    {
        return static::$administratorRepository;
    }

    /**
     * 查询用户名
     *
     * @param string $uname
     *
     * @return mixed
     */
    public function checkUser(string $uname)
    {
        return static::getAdministratorRespository()->queryUserByName($uname);
    }

    /**
     * 创建用户
     *
     * @param array $data
     *
     * @return mixed
     */
    public function createUser(array $data)
    {
        //1.判重
        //2.帐号检测
//        if ($this->checkUser($data['uname'])) {
            $b = static::getAdministratorRespository()->createUser($data);
//        }

        return $b??false;
    }
}