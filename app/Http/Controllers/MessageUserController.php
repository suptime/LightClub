<?php

namespace App\Http\Controllers;

use App\MessageUser;
use Illuminate\Http\Request;


class MessageUserController extends Controller
{

    /**
     * 用户标记指定系统消息为已读
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function readed(Request $request){
        if ($request->ajax()) {
            //取得查询条件
            $mid = $request->input('mid');
            $receive_uid = $request->user()->uid;
            $msg = MessageUser::whereRaw('id = ? AND receive_uid = ?', [$mid, $receive_uid])
                ->update(['read' => 1]);

            if ($msg){
                $status = 1;
                $msg = '标记已读完成';
            }else{
                $status = 0;
                $msg = '标记失败';
            }

            //返回json数据
            return response()->json([
                'status' => $status,
                'msg' => $msg
            ]);

        }
    }

    /**
     * 用户主动删除系统消息
     * @param $id
     */
    public function removeSystemMessage(Request $request, $id){
        $receive_uid = $request->user()->uid;
        $msg = MessageUser::whereRaw('id = ? AND receive_uid = ?', [$id, $receive_uid])->first();
        //删除成功
        if ($msg->delete()) {
            return redirect('user/notice')->with('success', '删除消息成功');
        }
        return redirect('user/notice')->with('error', '删除消息失败');
    }
}
