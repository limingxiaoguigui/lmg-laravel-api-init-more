<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2019-12-30 18:45:22
 * @LastEditors  : LMG
 * @LastEditTime : 2019-12-30 18:46:42
 */

namespace App\Http\Middleware\Api;

use Closure;

class AdminGuardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        config(['auth.defaults.guard' => 'admin']);
        return $next($request);
    }
}