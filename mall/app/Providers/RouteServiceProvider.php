<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        //custom frontend route
        $sld_prefix = isset($_SERVER['REQUEST_URI']) ?
            explode('/',trim($_SERVER['REQUEST_URI'],'/'))[0] :
            config('app.frontend');
        if(config('app.admin') == $sld_prefix){
            $this->mapAdminRoutes();
        } elseif (config('app.frontend') == $sld_prefix){
            $this->mapFrontendRoutes();
        } else {
            $this->mapWebRoutes();
        }
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }


    /*
     *
     */
    protected function mapFrontendRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace.'\Frontend')
            ->group(base_path('routes/frontend.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('admin')
            ->namespace($this->namespace.'\Admin')
            ->group(base_path('routes/admin.php'));
    }


}
