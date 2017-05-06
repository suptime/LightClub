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
        //获取当前登录用户资料
        $user = User::getVisitUserInfo($this->_uid);
        //获取当前登录用户的消息列表
        $sendUsers = Letter::getLettersList($this->_uid);
        $sendTo = $toid = $letter_list = false;

        //判断创建对话用户是否已传递
        if (isset($request->toid)) {
            if ($request->toid == $this->_uid){
                return redirect('user/letters')->with('error', '不能给自己发送消息');
            }

            //查询数据库中拥有此用户与当前登录用户的消息记录,如果没有,创建新会话
            $uids = [$this->_uid, $request->toid];
            $toid =  $request->toid;
            $speak = Letter::whereIn('send_uid',$uids)->whereIn('receive_uid',$uids)->count();
            if (!$speak){
                //查询用户数据
                $sendTo = User::select('uid', 'name', 'avstar')->where('uid', $request->toid)->where('status',1)->first();
                if (!$sendTo) {
                    return redirect('user/letters')->with('error', '无法给此用户发送消息');
                }
            }
        }

        return view('auth.letter', [
            'user' => $user,
            'sendUsers' => $sendUsers,
            'sendTo' => $sendTo,
            'toid' => $toid
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
