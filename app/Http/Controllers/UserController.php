<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Comment;
use App\MessageMain;
use App\MessageUser;
use App\Topic;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Http\Controllers\Controller;
use Mail;

class UserController extends Controller
{
    private $_uid;

    public function __construct()
    {
        //获取登录用户id
        if (Auth::check()) {
            $this->_uid = Auth::id();
            User::getMsgStatus();
        } else {
            $this->_uid = false;
        }
    }

    /**
     * 根据id获取对应会员发布的主题贴
     * @param $uid
     */
    public function userSpace($uid)
    {
        //访问用户是否存在
        if (!$user = User::getVisitUserInfo($uid)) {
            return redirect('/')->with('error', '无法访问主页,可能是不存在,未激活或被锁定');
        }
        //根据会员id获取对应主题帖
        $topics = Topic::getCurrentUserTopics($user->uid, config('app.web_config.pageSize'));
        //当前页面是否是登录会员的
        $isLoginStatus = ($uid == $this->_uid) ? true : false;
        //载入视图,分配数据
        return view('auth.space', [
            'user' => $user,
            'topics' => $topics,
            'current_uid' => $this->_uid,
            'isLoginStatus' => $isLoginStatus
        ]);
    }

    /**
     * 根据当前访问用户的id获取其所有评论
     * @param $uid
     */
    public function userReply($uid)
    {
        //访问用户是否存在
        if (!$user = User::getVisitUserInfo($uid)) {
            return redirect('/')->with('error', '无法访问主页,可能是不存在,未激活或被锁定');
        }
        //根据会员id获取其发布的回帖
        $comments = Comment::getVistCurrentUserComment($user->uid, config('app.web_config.pageSize'));
        //当前页面是否是登录会员的
        $isLoginStatus = ($uid == $this->_uid) ? true : false;
        //载入视图,分配数据
        return view('auth.reply', [
            'user' => $user,
            'comments' => $comments,
            'current_uid' => $this->_uid,
            'isLoginStatus' => $isLoginStatus
        ]);
    }


    /**
     * 用户资料修改
     * @param Request $request
     */
    public function userInfoSetting(Request $request)
    {
        //获取登录用户的信息
        $user = User::getUpdateUserData($this->_uid);
        if ($request->isMethod('POST')) {
            //验证数据
            $this->validate($request, User::$rules, User::$messages, User::$names);
            //对比数据库的密码,是否匹配
            $oldPassword = $request->oldpassword;
            if (!Hash::check($oldPassword, $user->password)) {
                return redirect('user/setting')->with('error', '旧密码错误,无法修改资料');
            }
            //接收数据
            $data = [
                'avstar' => $request->avstar,
                'mobile' => $request->mobile,
                'qqnum' => $request->qqnum,
                'password' => $request->password,
                'signature' => $request->signature,
            ];

            //去除空数据
            foreach ($data as $k => $v) {
                if (trim($v) == false || $user[$k] == $v) {
                    unset($data[$k]);
                }
            }
            //有数据才更新
            if ($data) {
                //密码加密
                if (isset($data['password'])) {
                    if ($data['password'] != $request->repassword){
                        return redirect('user/setting')->with('error', '新密码验证失败');
                    }
                    //验证通过,加密新密码
                    $data['password'] = bcrypt($data['password']);
                }

                //更新数据
                if (User::where('uid', $this->_uid)->update($data)) {
                    return redirect('user/setting')->with('success', '完成资料修改');
                }
            }
            return redirect('user/setting')->with('error', '修改失败,您没修改任何资料');
        }

        return view('auth.setting', [
            'user' => $user,
            'current_uid' => $this->_uid
        ]);
    }

    /**
     * 获取登录用户的收藏夹
     */
    public function collectionList()
    {
        //获取登录用户的信息
        $user = User::getVisitUserInfo($this->_uid);
        $favrates = Collection::getCollectionList($this->_uid, config('app.web_config.pageSize'));
        return view('auth.collection', [
            'favrates' => $favrates,
            'user' => $user,
            'current_uid' => $this->_uid
        ]);
    }

    /**
     * 获取系统消息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function systemMessages()
    {
        $notices = MessageUser::getSystemMessageData($this->_uid, config('app.web_config.pageSize'));
        //获取登录用户的信息
        $user = User::getVisitUserInfo($this->_uid);
        return view('auth.notice', [
            'notices' => $notices,
            'user' => $user,
            'current_uid' => $this->_uid
        ]);
    }

    /**
     * 后台用户列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminUserList(){
        $userModel = new User();
        $users = $userModel->paginate(config('app.web_config.pageSize'));
        return view('admin.user_list', [
            'userModel' => $userModel,
            'users' => $users,
        ]);
    }

    /**
     * 后台修改指定用户的状态资料
     * @param Request $request
     * @param $uid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function editOneUserInfo(Request $request,$uid){
        $user = User::find($uid);
        if ($request->isMethod('POST')) {
            $data = $request->except('_token');

            foreach ($data as $k => $v){
                if (trim($v) == $user[$k]){
                    unset($data[$k]);
                }
            }
            //如果没有修改任何数据
            if (!$data){
                return redirect('admin/users/list')->with('error', '未修改任何内容,无需保存');
            }

            //修改用户的状态信息
            if (User::where('uid',$uid)->update($data)) {
                return redirect('admin/users/list')->with('success', '修改成功');
            }
            return redirect()->back()->with('error', '修改失败');
        }

        //载入视图
        return view('admin.user_edit',[
            'user' => $user
        ]);
    }


    /**
     * 网站后台首页
     */
    public function adminIndex(){
        return view('admin.index');
    }

    /**
     * 发送激活邮件页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function activationAccount(Request $request){
        //获取登录用户的信息
        $user = $request->user();
        //判断用户是否已激活,已激活不允许访问此页面
        if ($user->status != 0) {
            return redirect('/');
        }

        //ajax请求发送邮件
        if ($request->ajax()) {
            //生成一个激活active_token并保存到数据库
            $active_token = str_random(64);
            User::where('uid',$user->uid)->update(['active_token' => $active_token]);
            //生成激活地址
            $url = url('user/active/?active_token='.$active_token.'&email='.$user->email.'&name='.$user->name);
            //发送邮件
            $result = Mail::send('auth.mail_tmp',[
                'sitename' => '豆萌社区',
                'url' => $url,
            ], function ($message) use ($user){
                $message->from('ucasp@qq.com', '豆萌社区');
                $message->to($user->email);
                $message->subject('用户账号激活邮件');
            });

            //判断邮件发送结果
            if ($result){
                $status = 'success';
            }else{
                $status = 'fail';
            }
            return response()->json([$status]);
        }

        return view('auth.activation',[
            'user' => $user,
        ]);
    }

    /**
     * 通过激活邮件中的链接跳转到网站激活验证请求
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function activeUserAccountOfToken(Request $request){
        //根据接收到的参数查询数据
        $active_token = $request->active_token;
        $email = $request->email;
        $name = $request->name;

        //根据条件查询一条数据
        $user = User::whereRaw('active_token = ? and status = ? and email = ? and name = ?',[$active_token, 0, $email, $name])->first();
        if ($user) {
            //存在数据,更改数据并载入视图.
            $user->update(['status' => 1]);

            //载入视图
            return view('auth.activation',[
                'user' => $user,
            ]);
        }else{
            //用户已激活,查无此账号则跳转到首页
            return redirect('/');
        }
    }
}
