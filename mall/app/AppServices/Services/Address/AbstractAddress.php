<?php
namespace App\AppServices\Services\Address;

use Illuminate\Container\Container as App;

/**
 * 用户地址管理.
 *
 * User: sai
 * Date: 2018-12-19
 * Time: 21:11
 */
abstract class AbstractAddress
{
    protected static $addressRepository;

    public function __construct(App $app)
    {
        if ( empty(static::getAddressRepository()) ) {
            static::$addressRepository = $app->make(
                'App\AppServices\Repositories\Address\AddressRepository'
            );
        }
    }

    protected static function getAddressRepository()
    {
        return static::$addressRepository;
    }

    abstract protected function initialize();

}