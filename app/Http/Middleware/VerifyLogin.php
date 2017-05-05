<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Auth;
use Illuminate\Http\Request;

class VerifyLogin
{
    public $excludePath = [
        'attachment/upload',
    ];
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
            if (in_array($request->path(), $this->excludePath)){
                return response()->json([
                    'code' => 1,
                    'msg' => '请登录后再使用此功能',
                    'data' => [
                        'src' => ''
                    ]
                ]);
            }
            return redirect('user/login');
        }

        $thisUser = User::getOnceUser();
        if ($thisUser->status == 0){
            return redirect('user/active');
        }
        //分配消息状态变量
        User::getMsgStatus();
        //判断是否有未读私信
        return $next($request);
    }
}
