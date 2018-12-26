<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Jobs\OrderPaidQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderPaidNotify
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderPaid  $event
     * @return void
     */
    public function handle(OrderPaid $event)
    {
        //放入队列
        dispatch(new OrderPaidQueue($event->order));
    }
}
