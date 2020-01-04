<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2019-12-31 11:02:16
 * @LastEditors  : LMG
 * @LastEditTime : 2019-12-31 11:02:50
 */

namespace App\Http\Middleware\Api;

use Closure;

class UserGuardMiddleware
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
        config(['auth.defaults.guard' => 'api']);
        return $next($request);
    }
}