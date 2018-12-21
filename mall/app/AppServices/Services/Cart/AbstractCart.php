<?php
namespace App\AppServices\Services\Cart;

use Illuminate\Container\Container as App;

/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-18
 * Time: 23:59
 */
abstract class AbstractCart
{
    protected static $cartRepository;

    public function __construct(App $app)
    {
        if (empty(static::getCartRespository())) {
            static::$cartRepository = $app->make('App\AppServices\Repositories\Cart\CartRepository');
        }
        $this->initialize();
    }

    abstract protected function initialize();

    public function getCartRespository()
    {
        return static::$cartRepository;
    }
}