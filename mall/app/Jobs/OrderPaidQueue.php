<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Libraries\Wechat\Message\Send;

class OrderPaidQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orderPaid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($orderPaid)
    {
        //
        $this->orderPaid = $orderPaid;
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
        //发微信模板
        try{
            $res = (new Send)
                ->template('orderSuccess')
                ->send($this->orderPaid->orders['openid'],$this->orderPaid->orders['order_sn'],
                    $this->orderPaid->orders['order_amount'],'货到付款');
        }catch(\Exception $e){
            echo $e->getMessage();
        }

        echo 'logger: 订单提交成功...'.json_encode($this->orderPaid->orders).''.json_encode($res);
    }
}
