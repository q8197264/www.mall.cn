<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // 获取当前认证用户...
        //$user = Auth::user();
        // 获取当前认证用户的ID...
        //   $id = Auth::id();

        if (Auth::guard($guard)->check()) {
            //
            switch ($guard) {
                case 'admin':
                    return redirect('/admin');
                    break;
                default:
                    return redirect('/home');
                    break;
            }
        }

        return $next($request);
    }
}
