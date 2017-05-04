<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{

    public function index(Request $request)
    {
        //获取系统配置数据
        $system_config = Config::first();
        if ($request->isMethod('POST')) {
            $data = $request->except('_token');

            $id = $data['id'];
            //删除为空的数据
            foreach ($data as $k => $v){
                if ( trim($v) == $system_config[$k]) {
                    unset($data[$k]);
                }
            }

            //如果数据为空
            if (!$data){
                return redirect()->back()->with('error', '没有修改任何数据');
            }

            $rs = Config::where('id', $id)->update($data);
            if ($rs === false) {
                return redirect()->back()->with('error', '修改配置失败');
            }
            return redirect()->back()->with('success', '修改配置完成');
        }

        return view('admin.system_config',[
            'system_config' => $system_config,
        ]);
    }

}
