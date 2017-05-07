<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Topic;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    /**
     * 新增回帖
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addReply(Request $request)
    {
        $comment = new Comment();
        //判断用户是否登录
        if (!Auth::check()) {
            return redirect('user/login');
        }
        //获取用户id
        $uid = $request->user()->uid;
        $tids = Topic::lists('tid')->toArray();
        $tids = implode(',', $tids);
        if ($request->isMethod('POST')) {
            $capcha = session()->get('challenge');
            //验证数据合法性
            $this->validate($request, [
                'comment' => 'required|min:10',
                'tid' => 'required|in:' . $tids,
                'geetest_challenge' => 'required|regex:/'.$capcha.'.*/',
            ], [
                'required' => ':attribute不能为空',
                'min' => ':attribute太短',
                'in' => ':attribute不合法',
                'regex'=> config('geetest.server_fail_alert'),
            ], [
                'comment' => '回帖内容',
                'tid' => '贴子不存在',
            ]);

            //接收数据
            $comment->comment = preg_replace('/^@(.*):/i', '', $request->comment);  //回帖内容
            $comment->tid = $comment->com_tid = $request->tid;  //主题贴id
            $comment->uid = $uid;       //当前评论用户id
            $comment->at_uid = $request->at_uid ? $request->at_uid : 0; //回复对象用户id
            $comment->pid = $request->pid ? $request->pid : 0;  //上级回帖id
            //插入数据
            if ($comment->save()) {
                User::setUserScore($uid);
                Comment::getCountComment($comment->tid);    //统计当前帖子的回复数量
                return redirect()->back()->with('success', '回帖成功,您获得了经验值与积分');
            } else {
                return redirect()->back()->with('error', '回帖失败!');
            }
        }
    }

    /**
     * 根据条件删除回复
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($id)
    {
        //判断用户是否已登录
        if (!Auth::check()) {
            return redirect('user/login');
        }
        //已登录用户获取用户id
        $uid = Auth::id();

        //根据回帖id获取用户id,再根据此用户id获取贴子id
        if (!$comment = Comment::select('id', 'tid', 'uid')->where('id', $id)->first()) {
            return redirect('/')->with('error', '没有这条回复');
        }

        //判断当前用户登录id是否与回帖用户id一致,一致就删除记录
        if ($uid == $comment->uid) {
            if ($comment->delete()) {
                Comment::deleteSonComment($comment->id);    //删除子评论
                Comment::getCountComment($comment->tid);    //统计当前帖子的回复数量
                return redirect()->back()->with('success', '删除回帖成功');
            } else {
                return redirect()->back()->with('error', '删除失败 (｀・ω・´)');
            }
        }

        //判断是否是帖子发布者,是就删除
        if ($topic = Topic::select('uid')->find($comment->tid)) {
            if ($uid == $topic->uid) {
                if ($comment->delete()) {
                    Comment::deleteSonComment($comment->id);    //删除子评论
                    Comment::getCountComment($comment->tid);    //统计当前帖子的回复数量
                    return redirect()->back()->with('success', '删除回帖成功');
                } else {
                    return redirect()->back()->with('error', '删除失败 （￣へ￣）');
                }
            }
        }

        if ($user = User::select('isadmin')->where('uid', $uid)->first()) {
            //检测是否是管理员
            if ($user->isadmin) {
                if ($comment->delete()) {
                    Comment::deleteSonComment($comment->id);    //删除子评论
                    Comment::getCountComment($comment->tid);    //统计当前帖子的回复数量
                    return redirect()->back()->with('success', '删除回帖成功');
                } else {
                    return redirect()->back()->with('error', '删除失败 (〜￣△￣)〜');
                }
            }
        }

        //无权限
        return redirect('topic/' . $comment->tid)->with('error', '删除失败 无权限');
    }

    /**
     * 用户点赞
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upvote(Request $request)
    {
        if ($request->ajax()) {
            $status = 0;
            $msg = '';
            //验证用户是否登录
            if (!Auth::check()) {
                $msg = '请登录后点赞';
            }

            //获取传递的值
            $id = $request->commentid;
            $type = $request->type;
            $num = $request->num;

            //主题点赞
            if ($type == 'topic') {
                if (Topic::where('tid', $id)->increment('upvote', 1)) {
                    $msg = '您赞了本帖一下';
                    $status = 1;
                    $num = $num + 1;
                } else {
                    $msg = '点赞失败';
                }
            }
            //回复点赞
            if ($type == 'comment') {
                if (Comment::where('id', $id)->increment('upvote', 1)) {
                    $msg = '您赞了一下';
                    $status = 1;
                    $num = $num + 1;
                } else {
                    $msg = '点赞失败';
                }
            }
            //返回json
            if ($msg) {
                return response()->json([
                    'status' => $status,
                    'msg' => $msg,
                    'num' => $num,
                ]);
            } else {
                return response()->json([
                    'status' => $status,
                    'msg' => $msg,
                ]);
            }
        }
    }

    /**
     * 后台回帖里列表管理
     */
    public function adminCommentList(){
        $comments = Comment::select('comments.*','users.name')
            ->join('users', 'comments.uid', '=','users.uid')
            ->orderBy('created_at', 'desc')
            ->paginate(config('app.web_config.pageSize'));
        return view('admin.comments_list',[
            'comments' => $comments,
        ]);
    }

    /**
     * 更改指定数据状态.
     * @param $id
     */
    public function adminShow($id){
        //查找符合条件的数据
        $comment = Comment::find($id);

        if ($comment->is_show == 1){
            $status = 0;
        }else{
            $status = 1;
        }

        //更新数据
        if (Comment::where('id', '=', $id)->update(['is_show' => $status])) {
            return redirect()->back()->with('success', '显示状态更改成功');
        }else{
            return redirect()->back()->with('error', '显示状态更改失败');
        }
    }
}
