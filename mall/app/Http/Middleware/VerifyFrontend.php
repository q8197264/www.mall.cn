<?php
namespace App\Http\Middleware;

use Closure;

/**
 * Created by PhpStorm.
 * User: liuxiaoquan
 * Date: 2018-11-22
 * Time: 14:36
 */
class VerifyFrontend
{
    public function handle($request,  Closure $next)
    {
        //if () {
            return $next($request);
        //}

        //return jump to web home.
        //return redirect('/');
    }
}