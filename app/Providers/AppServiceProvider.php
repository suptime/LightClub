<?php

namespace App\Providers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 或者直接使用 \DB::
        /*DB::listen(function($sql, $bindings, $time) {
            dump($sql);
        });*/
        //获取所有分类
        $data = Category::select('cid','catname','catdir')->where('status', '=', 1)->get()->toArray();
        //共享视图数据
        view()->share('navs', $data);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
