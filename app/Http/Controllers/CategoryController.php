<?php

namespace App\Http\Controllers;

use App\Category;
use App\Topic;

use App\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public $model;

    /**
     * 获取模型
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->model = new Category();
    }

    /**
     * 前台首页与分类列表页
     * @param Request $request http请求对象
     * @param string $catdir 分类uri参数,为catdir字段内容
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function homeList(Request $request, $catdir = '')
    {
        $orderBy = 'tid';    //指定默认排序参数
        $type_arg = $cid = '';  //指定默认分页参数和默认分类id
        $type = $request->type;    //获取请求排序参数

        User::getMsgStatus();

        //判断请求参数是否合法    排序参数为time,repley,hot,只有满足这三个参数才可以定义排序
        $orderTypes = ['reply' => 'replyTime', 'hot' => 'reply_total'];
        $keys = array_keys($orderTypes);    //将key取出来
        if (isset($type) && in_array($type, $keys)) {
            $orderBy = $orderTypes[$type];
            $type_arg = ['type' => $type];
        }

        //根据分类参数获取分类id
        if ($catdir) {
            if (!$category = $this->model->where('catdir', $catdir)->first()) {
                return abort(404); //如果查询结果不存在,返回404错误
            }
            $cid = $category->cid;
        }

        //获取栏目TKD
        $classInfo = [
            'title' => isset($category->catname) ? $category->catname : '',
            'catdir' => isset($category->catdir) ? $category->catdir : '',
            'keywords' => isset($category->keywords) ? $category->keywords : '',
            'description' => isset($category->description) ? $category->description : '',
            'cid' => isset($cid) ? $cid : '/',  //获得分类id
        ];

        //查询主题贴,创建Topic对象
        $topicModel = new Topic();
        //将符合条件的主题贴查询出来
        if ($orderBy == 'replyTime'){
            $topics = $topicModel->getReplySortList(config('app.web_config.pageSize'), $cid, $orderBy);
        }else{
            $topics = $topicModel->getAllTopic(config('app.web_config.pageSize'), $cid, $orderBy);
        }

        //查询侧栏热帖
        $hotTopics = $topicModel->getCustomTopics('click', 8);

        //引入数据到视图
        return view('topic.index', [
            'topics' => $topics,
            'type_arg' => $type_arg,
            'hotTopics' => $hotTopics,
            'classInfo' => $classInfo,
            'type_arg' => $type_arg,
        ]);
    }

    /**
     * 后台分类首页展示
     */
    public function index()
    {
        $this->model->getStatus('status');
        //获取全部分类
        $categories = Category::all()->toArray();
        //载入视图,分配数据
        return view('admin.category_list', [
            'cateModel' => $this->model,
            'categories' => $categories,
        ]);
    }

    /**
     * 新增分类
     * @param Request $request 请求类型
     */
    public function add(Request $request)
    {
        //判断请求类型
        if ($request->isMethod('POST')) {
            //验证数据合法性
            $this->validate($request, $this->model->rules, $this->model->messages, $this->model->attrs);
            //接收表单数据
            $data = $request->only(['catname', 'parent_id', 'catdir', 'keywords', 'description', 'status', 'ischannel']);
            //插入数据
            if ($this->model->create($data)) {
                return redirect('admin/category/list')->with('success', '新增分类成功');
            } else {
                return redirect()->back()->with('error', '新增失败');
            }
        }

        //获取所有分类
        $cates = $this->model->getCateTree();
        //载入视图,传递数据
        return view('admin.category_post', ['cates' => $cates, 'cateModel' => $this->model]);
    }

    /**
     * 修改分类
     * @param Request $request
     * @param $cid  分类主键id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function update(Request $request, $cid)
    {
        //判断请求类型
        if ($request->isMethod('POST')) {
            //验证数据合法性
            $this->validate($request, $this->model->rules, $this->model->messages, $this->model->attrs);
            //接收表单数据
            $data = $request->only(['catname', 'parent_id', 'catdir', 'keywords', 'description', 'status', 'ischannel']);
            //修改数据
            if ($this->model->where('cid', $cid)->update($data)) {
                return redirect('admin/category/list')->with('success', '分类修改成功');
            } else {
                return redirect()->back()->with('error', '修改失败');
            }
        }
        //根据主键获取一条记录
        $category = $this->model->find($cid)->toArray();
        //获取所有分类
        $cates = $this->model->getCateTree();
        //载入视图,传递数据
        return view('admin.category_post', [
            'cates' => $cates,
            'cateModel' => $this->model,
            'category' => $category,
        ]);
    }


    /**
     * 根据主键删除分类
     * @param $cid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($cid)
    {
        //查询是否有符合条件的数据
        if (!$category = Category::find($cid)) {
            return abort(404);
        }
        //判断分类是否存在数据
        if (Topic::where('cid', $cid)->count() > 0) {
            return redirect()->back()->with('error', '分类中存在贴子,不允许删除');
        }
        //删除符合条件的数据,并判断执行结果
        if (!$category->delete()) {
            return redirect('admind/category/list')->with('error', '删除失败');
        }
        return redirect('admind/category/list')->with('success', '成功删除分类,ID为' . $cid);
    }
}
