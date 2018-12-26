<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Libraries\Wechat\Response\Response;

class OrderPaidQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        //
        $this->message = $message;
    }

    /**
     * 注：
     * 消费端：在命令终端启用命令：php artisan queue:work [可选]--queue=queueName 常驻进程
     * 生产者：用dispath函数发送任务：dispatch(new OrderPaidQueue());
     *
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        sleep(5);
        $wechat = new Response();
        print_r($this->message);
        echo 'Send queue order paid message...';
    }
}
