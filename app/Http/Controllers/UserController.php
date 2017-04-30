<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Comment;
use App\Topic;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $_uid;

    public function __construct()
    {
        //获取登录用户id
        if (Auth::check()){
            $this->_uid = Auth::id();
        }else{
            $this->_uid = false;
        }
    }

    /**
     * 根据id获取对应会员发布的主题贴
     * @param $uid
     */
    public function userSpace($uid){
        //访问用户是否存在
        if (!$user = User::getVisitUserInfo($uid)) {
            return redirect('/')->with('error', '无法访问主页,可能是不存在,未激活或被锁定');
        }
        //根据会员id获取对应主题帖
        $topics = Topic::getCurrentUserTopics($user->uid, config('app.web_config.pageSize'));
        //载入视图,分配数据
        return view('auth.space',[
            'user' => $user,
            'topics' => $topics
        ]);
    }

    /**
     * 根据当前访问用户的id获取其所有评论
     * @param $uid
     */
    public function userReply($uid){
        //访问用户是否存在
        if (!$user = User::getVisitUserInfo($uid)) {
            return redirect('/')->with('error', '无法访问主页,可能是不存在,未激活或被锁定');
        }

        //根据会员id获取其发布的回帖
        $comments = Comment::getVistCurrentUserComment($user->uid, config('app.web_config.pageSize'));

        //载入视图,分配数据
        return view('auth.reply',[
            'user' => $user,
            'comments' => $comments
        ]);
    }


    /**
     * 用户资料修改
     * @param Request $request
     */
    public function userInfoSetting(Request $request){
        //获取登录用户的信息
        $user = User::getVisitUserInfo($this->_uid);
        if ($request->isMethod('POST')){
            //验证数据
            $this->validate($request, User::$rules, User::$messages, User::$names);
            //接收数据
            $data = [
                'avstar' => $request->avstar,
                'mobile' => $request->mobile,
                'qqnum' => $request->qqnum,
                'password' => $request->password,
                'signature' => $request->signature,
            ];

            //去除空数据
            foreach ($data as $k => $v){
                if (trim($v) == false || $user[$k] == $v){
                    unset($data[$k]);
                }
            }
            //有数据才更新
            if ($data){
                //更新数据
                if (User::where('uid',$this->_uid)->update($data)) {
                    return redirect()->back()->with('success', '完成资料修改');
                }else{
                    return redirect()->back()->with('error', '资料修改失败');
                }
            }
            return redirect()->back()->with('error', '您没修改任何资料');
        }

        return view('auth.setting',[
            'user'=>$user,
        ]);
    }


    public function collectionList(){
        //获取登录用户的信息
        $user = User::getVisitUserInfo($this->_uid);
        $favrates = Collection::getCollectionList($this->_uid,config('app.web_config.pageSize'));
        return view('auth.collection',[
            'favrates' => $favrates,
            'user' => $user,
            'current_uid' => $this->_uid
        ]);
    }
}
