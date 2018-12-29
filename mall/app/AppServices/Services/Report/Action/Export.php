<?php

namespace Services\Report\Action;

use Illuminate\Container\Container as App;
use App\AppServices\Repositories\Order\OrderRepository;

/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-28
 * Time: 12:12
 */
class Export
{
    private $format = [
        'excel' => \Services\Report\Format\Excel::class,
        'csv'   => \Services\Report\Format\CSV::class,
    ];

    protected $app;

    protected $orderRepository;

    /**
     *
     * Export constructor.
     *
     * @param string $from
     * @param string $to
     * @param App    $app
     */
    public function __construct(App $app, OrderRepository $orderRepository)
    {
        $this->app             = $app;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @return $this
     */
    public function fetch()
    {
        $this->data = call_user_func_array([$this->orderRepository, 'getSales'], func_get_args());

        return $this;
    }

    /**
     * @param string|null $path
     *
     * @return mixed
     */
    public function save(string $path = null)
    {
        $res = call_user_func([$this->target, 'export'], $this->data, $path);

        return $res;
    }


    /**
     * 连贯操作
     *
     * @param $classname
     * @param $arguments
     *
     * @return $this
     */
    public function __call($classname, $arguments)
    {
        $this->target = $this->app->make($this->format[$classname]);

        return $this;
    }
}