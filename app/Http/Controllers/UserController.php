<?php

namespace App\Http\Controllers;

use App\Topic;
use App\User;
use Validator;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    /**
     * 根据id获取对应会员发布的主题贴
     * @param $uid
     */
    public function userSpace($uid){

        $user = User::getVisitUserInfo($uid);
        //访问用户是否存在
        if (!$user) {
            return redirect('/')->with('error', '无法访问主页,可能是不存在,未激活或被锁定');
        }
        //根据会员id获取对应主题帖
        $topics = Topic::getCurrentUserTopics($uid, config('app.web_config.pageSize'));
        //载入视图,分配数据
        return view('auth.space',[
            'user' => $user,
            'topics' => $topics
        ]);
    }



}
