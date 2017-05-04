<?php

namespace App\Providers;

use App\Category;
use App\Config;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        // 或者直接使用 \DB::
        /*DB::listen(function($sql, $bindings, $time) {
            dump($sql);
        });*/

        //获取当前页面路径
        $pathArr = explode('/', $request->path());
        //判断是否是admin
        if (!in_array('admin', $pathArr)){

            //获取站点配置信息
            $configs = Config::first()->toArray();
            if ($configs['site_status'] == 0){
                exit('网站暂停运营');
            }

            //获取所有分类
            $data = Category::select('cid','catname','catdir')->where('status', '=', 1)->get()->toArray();

            //共享视图数据
            view()->share('navs', $data);
            view()->share('configs', $configs);
        }
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
