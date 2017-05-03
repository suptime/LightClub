<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VerifyLogin
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
        //全局验证用户是否登录
        if (!Auth::check()) {
            //获取当前页面的路由规则
            $name = $request->path();
            return redirect('user/login');
        }

        $uid = $request->user()->id;

        return $next($request);
    }
}
