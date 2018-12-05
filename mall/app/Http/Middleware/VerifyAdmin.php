<?php
namespace App\Http\Middleware;

use Closure;

/**
 * Created by PhpStorm.
 * User: liuxiaoquan
 * Date: 2018-11-22
 * Time: 14:40
 */
class VerifyAdmin
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}