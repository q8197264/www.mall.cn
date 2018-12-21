<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // 注册新的云存储驱动
//        Storage::extend('qiniu', function ($app, $config) {
//            return new Filesystem(new QiniuAdapter('storage'));
//        });

//        编写好以上代码之后，就可以通过类似如下方式存储图片
//        Storage::disk('qiniu')->write('test/academy/logo.png',
//            storage_path('app/public/images/logo.png'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
