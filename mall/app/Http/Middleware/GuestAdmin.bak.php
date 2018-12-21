<?php

namespace App\Http\Middleware;

use Closure;

class GuestAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,  $guard = null)
    {
        if (auth()->guard('admin')->check()) {
            //return redirect('/home');

            // 根据不同 guard 跳转到不同的页面
            $url = $guard ? 'admin/dash':'/home';
            return redirect($url);
        }

        return $next($request);
    }
}
