<?php
/*
 * @Author: DanceLynx
 * @Description: 验证邮箱激活中间件
 * @Date: 2020-06-20 20:38:07
 */

namespace App\Http\Middleware;

use Closure;

class EnsureEmailIsVerified
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
        if (
            $request->user() &&
            !\Auth::user()->hasVerifiedEmail() &&
            !$request->is(['email/*', 'logout'])
        ) {
            return $request->expectsJson()
                ? abort(403, 'Your email address not verified!')
                : redirect()->route('verification.notice');
        }
        return $next($request);
    }
}
