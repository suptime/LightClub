<?php

namespace App\Http\Controllers;

use App\MessageMain;
use Illuminate\Http\Request;


class MessageMainController extends Controller
{
    /**
     * 后台消息管理列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //获取所有消息
        $messages = MessageMain::getMsgList(config('app.web_config.pageSize'));
        return view('admin.message_list',[
            'messages' => $messages,
        ]);
    }

    /**
     * 发送系统短消息
     * @param Request $request
     */
    public function add(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->all();
            //获得当前登录用户的id确定发信人
            $data['uid'] = $request->user()->uid;
            //发送并保存消息
            $messageMain = new MessageMain();

            //新增消息
            if ($rs = $messageMain->addOneMessage($data)) {
                return redirect('admin/message/list')->with('success', '消息推送成功');
            }else{
                return redirect('admin/message/add')->with('error', '消息推送失败');
            }
        }

        return view('admin.message_post');
    }

    public function edit($id)
    {
        //
    }

}
