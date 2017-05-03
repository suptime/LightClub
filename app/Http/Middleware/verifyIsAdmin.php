<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class verifyIsAdmin
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

        //用户是否是管理员
        if (!$isadmin = User::Where('uid',Auth::id())->pluck('isadmin')) {
            return redirect('/')->with('error', '你没有权限浏览此页面');
        }
        return $next($request);
    }
}
