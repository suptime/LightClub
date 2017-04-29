<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Topic;
use App\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Response;
use Storage;
use Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class TopicController extends Controller
{
    public $model;

    private $mimeType = ['image/jpeg', 'image/png', 'image/gif'];


    /**
     * 初始化保存模型对象
     * TopicController constructor.
     */
    public function __construct()
    {
        $this->model = new Topic();
    }


    /**
     * 后台主题贴列表
     */
    public function adminTopicList()
    {
        //获取所有分类
        $pageSize = config('app.web_config.pageSize');
        $topics = $this->model->getAllTopic($pageSize, '', 'created_at', 'admin');
        //引入数据到视图
        return view('admin.topic_list', [
            'topics' => $topics
        ]);
    }

    /**
     * 主题审核状态修改,包括加精/取消加精,置顶/取消置顶, 审核/取消审核, 封禁/取消封禁
     * @param $tid  主题帖id
     * @param $operate  操作类型,为数据库对应字段
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminTopicExamine($tid, $operate)
    {
        //查询一条数据
        $topic = $this->model->getOnceTopic($tid);
        //判断操作类型
        $operates = ['isshow', 'islook', 'isgood', 'istop'];
        if (in_array($operate, $operates)) {
            //修改数据对应的状态
            if ($topic[$operate]) {
                if (Topic::where('tid', $topic['tid'])->update([$operate => 0])) {
                    return redirect('admin/topic/list')->with('success', $operate . '状态修改成功');
                } else {
                    return redirect('admin/topic/list')->with('success', $operate . '状态修改失败');
                }
            }
            if (Topic::where('tid', $topic['tid'])->update([$operate => 1])) {
                //加精和置顶成功,增加会员积分与经验
                if ($operate == 'isgood' && $operate == 'istop') {
                    User::setUserScore($topic['uid']);
                }
                return redirect('admin/topic/list')->with('success', $operate . '状态修改成功');
            } else {
                return redirect('admin/topic/list')->with('success', $operate . '状态修改失败');
            }
        }
    }

    /**
     * 根据主键删除一条符合条件的主题贴
     * @param $tid
     */
    public function adminTopicRemove($tid)
    {
        //查看用户是否有权限删除
        if (!Auth::check()) {
            return redirect('user/login');
        }
        //获取用户id
        $uid = Auth::id();
        //查找数据是否存在 && 帖子发布者是否是当前登录用户
        if (!$topic = Topic::find($tid)) {
            return abort(404);
        }
        //查询当前登录用户是否是管理员
        $user = User::select('uid','isadmin')->find($uid);
        //判断是否有权限执行删除
        if ($uid == $topic->uid || $user->isadmin == 'isadmin'){
            //删除数据  同时删除主表与附表的数据
            if (!($topic->delete() == DB::table('topic_details')->where('tid', $tid)->delete())) {
                return redirect('/')->with('success', '帖子删除失败');
            }
        }
        return redirect('/')->with('success', '帖子删除成功');
    }

    /**
     * 用户发布主题帖
     * @param Request $request
     */
    public function add(Request $request)
    {
        //判断请求类型
        if ($request->isMethod('POST')) {
            //判断用户是否登录
            if (!$user = $request->user()) {
                return redirect('user/login');
            }

            //验证数据
            $this->validate($request, $this->model->rules, $this->model->messages, $this->model->attrs);

            //获取数据
            $this->model->title = $request->title;
            $this->model->cid = $request->cid;
            $this->model->uid = $user->uid;

            $content = $request->input('content');

            //判断是否为图文贴
            $this->model->ispic = $this->model->isAssetImage($content);

            //插入数据到主表
            if (!$this->model->save()) {
                return redirect()->back()->with('error', '发布失败');
            }

            $tid = $this->model->tid;

            //插入数据到附表
            $bool = DB::table('topic_details')->insert([
                'tid' => $tid,
                'content' => $content,
            ]);

            //判断数据是否插入成功
            if ($bool) {
                //发贴成功增加会员积分
                User::setUserScore($user->uid);
                return redirect('topic/' . $tid)->with('success', '主题发表成功');
            } else {
                return redirect()->back()->with('error', '发布失败');
            }
        }

        return view('topic.add');
    }


    /**
     * 用户编辑主题帖
     * @param Request $request
     * @param $tid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request, $tid)
    {

        //检测数据是否存在
        if (!$topic = $this->model->find($tid)) {
            abort(404);
        }

        //判断请求类型
        if ($request->isMethod('POST')) {
            //验证数据合法性
            $this->validate($request, $this->model->rules, $this->model->messages, $this->model->attrs);

            $topic->title = $request->title;
            $topic->cid = $request->cid;

            //获取修改后的内容
            $content = $request->input('content');

            //判断是否为图文贴
            $topic->ispic = $this->model->isAssetImage($content);

            //更新数据到主表
            if ($topic->save() === false) {
                return redirect()->back()->with('error', '修改失败');
            }

            //更新数据到附表
            $num = DB::table('topic_details')
                ->where('tid', $topic->tid)
                ->update(['content' => $content]);

            //判断数据是否修改成功
            if ($num === false) {
                return redirect()->back()->with('error', '修改失败');
            } else {
                return redirect('topic/' . $tid)->with('success', '修改成功');
            }
        }

        $topic->content = DB::table('topic_details')->where('tid', $tid)->value('content');
        $topic->catname = Category::where('cid', $topic->cid)->value('catname');

        return view('topic.update', [
            'topic' => $topic,
        ]);
    }

    /**
     * 根据用户id增加用户积分与经验
     * @param $uid  用户id
     */
  /*  public function setUserScore($uid)
    {
        DB::table('users')->where('uid', $uid)->increment('score', 5);
        DB::table('users')->where('uid', $uid)->increment('grade', 20);
    }*/


    /**
     * 编辑器ajax请求上传图片
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function uploadfile(Request $request)
    {
        if ($request->isMethod('POST')) {
            $file = $request->file('file');

            //验证文件是否合法
            if ($file->isValid()) {
                $mime = $file->getClientMimeType();
                $ext = $file->getClientOriginalExtension();
                $realPath = $file->getRealPath();    //临时文件的绝对路径

                //验证mime类型是否合法
                if (!in_array($mime, $this->mimeType)) {
                    return response()->json([
                        'code' => 1,
                        'msg' => '文件类型不合法',
                        'data' => [
                            'src' => ''
                        ]
                    ]);
                }

                //构造文件保存路径
                $fileName = date('Ym/', time()) . uniqid() . '.' . $ext;
                //保存文件
                $bool = Storage::disk('upload')->put($fileName, file_get_contents($realPath));

                //判断文件保存结果
                if ($bool) {
                    return response()->json([
                        'code' => 0,
                        'msg' => '',
                        'data' => [
                            'src' => '/uploads/images/' . $fileName
                        ]
                    ]);
                } else {
                    return response()->json([
                        'code' => 1,
                        'msg' => '文件上传失败',
                        'data' => [
                            'src' => ''
                        ]
                    ]);
                }
            }
        }

        return redirect('/');
    }


    /**
     * 帖子详情页
     * @param $tid 帖子id
     */
    public function detail($tid)
    {
        //查询详情数据
        $topic = $this->model->getOnceTopic($tid);
        //获取主题帖内容
        $topic['content'] = DB::table('topic_details')->where('tid', $tid)->value('content');

        //判断数据是否符合审核与封禁条件
        if ($topic['isshow'] != 1 || $topic['islook'] != 1){
            return redirect('/')->with('error', '当前主题无法查看');
        }

        //获取回帖
        $comments = Comment::getCommentsAndUsers($tid);

        //将顶级回复取出来
        $commentsTop = $commentsSon = [];
        foreach ($comments as $v){
            $v['level'] = User::getUserLevel($v['grade']);
            if ($v['pid'] == false) {
                $commentsTop[] = $v;
            }else{
                $commentsSon[] = $v;
            }
        }

        //顶级回复贴分页
        $commentsTop = $this->getCousetPagination($commentsTop, config('app.web_config.pageSize'));

        //查询侧栏热帖
        $hotTopics = $this->model->getCustomTopics('click', 8);
        //新增浏览数
        Topic::where('tid', $tid)->increment('click', 1);

        //载入视图,分配数据
        return view('topic.detail', [
            'topic' => $topic,
            'hotTopics' => $hotTopics,
            'commentsTop' => $commentsTop,
            'commentsSon' => $commentsSon,
        ]);
    }

    /**
     * 数组自定义分页
     * @param $data array   传入的数据数组
     * @param $perPage  分页显示条数
     * @return LengthAwarePaginator|void    内置分页类
     */
    public function getCousetPagination($data, $perPage)
    {
        //实例化collect方法
        $collection = new Collection($data);
        //获取data总数
        $total = count($collection);
        //获取当前页码
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        //判断分页是否大于总页数
        $totalPage = ceil($total / $perPage);
        $totalPage =  $totalPage ? $totalPage : 1;
        if($currentPage > $totalPage){
            return abort(404);
        }
        //获取当前需要显示的数据列表
        $item = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        //创建一个新的分页方法
        $topComments= new LengthAwarePaginator($item, $total, $perPage, $currentPage, [
            //设定个要分页的url地址。也可以手动通过 $paginator ->setPath('路径') 设置
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
        return $topComments;
    }
}