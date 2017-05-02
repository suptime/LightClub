<?php

namespace App\Http\Controllers;

use App\Letter;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LetterController extends Controller
{
    private $_uid;

    /**
     * LetterController constructor.
     * @param $_uid
     */
    public function __construct()
    {
        //获取当前用户id
        $this->_uid = Auth::id();
    }

    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //获得传递的参数
        $sendTo = null;
        if (isset($request->toid)) {
            $uids = [$request->toid, $this->_uid];
            //判断消息表中是否有此会话用户数据,如果有,不查询数据出来
            $letter = Letter::whereIn('send_uid',$uids)->whereIn('receive_uid',$uids)->count();
            if (!$letter) {
                //查询用户数据
                $sendTo = User::select('uid', 'name', 'avstar')->where('uid', $request->toid)->where('status',1)->first();
                if (!$sendTo) {
                    return redirect('user/letters')->with('error', '无法给此用户发送消息');
                }
            }
        }

        //获取登录用户的信息
        $user = User::getVisitUserInfo($this->_uid);
        //获取发送给本用户的用户信息
        $sendUsers = Letter::getLettersList($this->_uid);
        return view('auth.letter', [
            'user' => $user,
            'sendUsers' => $sendUsers,
            'sendTo' => $sendTo,
        ]);
    }

    /**
     * ajax获取指定用户之间的通讯私信
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnLetters(Request $request)
    {
        if ($request->ajax()) {
            $send_uid = $request->send_uid;
            $receive_uid = $this->_uid;

            //根据获取的数据查询出符合条件的消息
            if ($data = Letter::getSendUserLetters([$send_uid, $receive_uid])) {
                $data['letters'] = $data;
                $data['status'] = 1;
            } else {
                $data = '';
                $data['status'] = 0;
                $data['msg'] = '获取消息消息列表失败';
            }
            //返回消息列表
            return response()->json($data);
        }
    }


    public function userSendMessage(Request $request)
    {
        if ($request->ajax()) {
            $letterModel = new Letter();
            //获得所需数据
            $send_uid = $letterModel->send_uid = $this->_uid;
            $receive_uid = $letterModel->receive_uid = (int)$request->receive_uid;
            $letterModel->letter = $request->letter;
            $letterModel->created_at = time();

            //将获取的数据插入到数据表中
            if (!$letterModel->save()) {
                $data = '';
                $data['status'] = 0;
                $data['msg'] = '发送消息失败';
            }

            //根据获取的数据查询出符合条件的消息
            if ($data = Letter::getSendUserLetters([$send_uid, $receive_uid])) {
                $data['letters'] = $data;
                $data['status'] = 1;
            } else {
                $data = '';
                $data['status'] = 0;
                $data['msg'] = '获取消息消息列表失败';
            }
            //返回消息列表
            return response()->json($data);
        }
    }

    /**
     * 用户删除会话记录,删除数据表中所有关联的数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userDeleteMConversation(Request $request)
    {
        if ($request->ajax()) {
            //根据获取的数据查询出符合条件的消息
            if ($data = Letter::deleteConversationData([$this->_uid, $request->send_uid])) {
                $status = 1;
                $msg = '会话已删除';
            } else {
                $status = 0;
                $msg = '删除失败';
            }
            //返回消息列表
            return response()->json([
                'status' => $status,
                'msg' => $msg,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
