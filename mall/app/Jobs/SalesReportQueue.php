<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Services\Services;

class SalesReportQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $services;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Services $services)
    {
        //
        $this->services = $services;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $this->services->report()->fetch('2018-12-22 12:21:25','2018-12-27 10:22:50')
            ->export()
            ->excel()
            ->save('/www/www.mall.cn/mall/storage/');
    }
}
