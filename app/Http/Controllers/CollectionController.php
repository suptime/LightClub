<?php
/**
 * FileName: CollectionController.php
 */

namespace App\Http\Controllers;


use App\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{

    /**
     * 收藏帖子
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function changeCollection(Request $request){
        //判断是否是ajax请求
        if ($request->ajax()) {
            //创建model对象
            $conllectionModel = new Collection();
            //赋值
            $conllectionModel->tid = $request->tid;
            $conllectionModel->uid = $request->user()->uid;

            //查询数据库中是否包含有收藏的记录
            $conllection = Collection::where('tid',$request->tid)->where('uid',$request->user()->uid)->first();
            if (count($conllection)){
                //如果存在,就删除此记录
                if ($conllection->delete()) {
                    $status = 1;
                    $msg = '取消收藏成功';
                    $type = 'del';
                }else{
                    $status = 0;
                    $msg = '取消收藏失败';
                    $type = '';
                }
            }else{
                //如果不存在记录,就将获取的数据插入到数据表中
                if ($conllectionModel->save()) {
                    $status = 1;
                    $msg = '添加收藏成功';
                    $type = 'add';
                }else{
                    $status = 0;
                    $msg = '取消收藏失败';
                    $type = '';
                }
            }

            //返回json
            return response()->json([
                'status' => $status,
                'msg' => $msg,
                'type' => $type,
            ]);
        }

        //不是ajax请求
        return abort(404);
    }
}