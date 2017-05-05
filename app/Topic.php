<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Topic extends Model
{

    protected $table = 'topics';

    protected $primaryKey = 'tid';

    protected $fillable = ['title', 'content', 'tags'];

    public $timestamps = true;

    public $rules = [
        'title' => 'required|max:255',
        'content' => 'required',
        'cid' => 'required|not_in:0',
    ];

    public $messages = [
        'required' => ':attribute不能为空',
        'max' => ':attribute不能为空太长',
        'not_in' => ':attribute未选择',
    ];

    public $attrs = [
        'title' => '主题',
        'content' => '内容正文',
        'cid' => '分类',
    ];

    /**
     * 获取原始时间戳,非格式化时间
     * @param mixed $value
     * @return mixed
     */
    protected function asDateTime($value)
    {
        return $value;
    }

    /**
     * 验证用户输入的标签是否合法
     * @param $tags
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyTags($tags){
        //如果标签为空,删除tags属性
        $tagStr = str_replace(' ', '', $tags);
        if (!$tagStr){
            unset($this->model->tags);
        }

        //格式化标签,以|分割标签保存到数据表中
        $tags = explode(' ', $tags);

        //验证标签填写个数是否合法
        if (count($tags) > 3){
            return false;
        }

        //判断单个标签长度
        foreach ($tags as $v){
            if (strlen($v) > 26){
                return false;
            }
        }

        return serialize($tags);
    }

    /**
     * 列表页获取主题信息
     * @param integer $pageSize 每页显示数量
     * @param string $cid 分类id
     * @param string $orderBy 排序方式
     * @return array & object mixed    对象或数组
     */
    public function getAllTopic($pageSize, $cid = '', $orderBy = 'tid', $platform = '')
    {
        if ($orderBy == 'reply_total') {
            $istop = 'reply_total';
        } else {
            $istop = 'topics.istop';
        }
        //后台管理列表
        if ($platform == 'admin') {
            return $this->join('categories', 'topics.cid', '=', 'categories.cid')
                ->join('users', 'topics.uid', '=', 'users.uid')
                ->select('topics.*', 'categories.catname', 'categories.catdir', 'users.name', 'users.avstar')
                ->orderBy($istop, 'desc')
                ->orderBy($orderBy, 'desc')
                ->paginate($pageSize);
        }

        //主题帖查询结果
        return $this->join('categories', function ($join) use ($cid) {
            if ($cid) {
                $join->on('topics.cid', '=', 'categories.cid')
                    ->where('topics.cid', '=', $cid)
                    ->where('topics.islook', '=', 1)
                    ->where('topics.isshow', '=', 1);
            } else {
                $join->on('topics.cid', '=', 'categories.cid')
                    ->where('topics.islook', '=', 1)
                    ->where('topics.isshow', '=', 1);
            }
        })
            ->join('users', 'topics.uid', '=', 'users.uid')
            ->select('topics.*', 'categories.catname', 'categories.catdir', 'users.name', 'users.avstar')
            ->orderBy($istop, 'desc')
            ->orderBy($orderBy, 'desc')
            ->paginate($pageSize);
    }

    /**
     * 按回复时间排序
     * @param $pageSize
     * @param string $cid
     * @param string $orderBy
     * @param string $platform
     */
    public function getReplySortList($pageSize, $cid)
    {
        $data = $this->join('categories', function ($join) use ($cid) {
            if ($cid) {
                $join->on('topics.cid', '=', 'categories.cid')
                    ->where('topics.cid', '=', $cid)
                    ->where('topics.islook', '=', 1)
                    ->where('topics.isshow', '=', 1);
            } else {
                $join->on('topics.cid', '=', 'categories.cid')
                    ->where('topics.islook', '=', 1)
                    ->where('topics.isshow', '=', 1);
            }
        })
            ->join('users', 'topics.uid', '=', 'users.uid')
            ->leftjoin('comments', 'topics.tid', '=', 'comments.com_tid')
            ->select('topics.*', 'categories.catname', 'categories.catdir', 'users.name', 'users.avstar', 'comments.id', 'comments.com_tid')
            ->groupBy('comments.com_tid', 'topics.tid')
            ->orderBy('comments.id', 'desc')
            ->paginate($pageSize);

        return $data;
    }

    /**
     * 根据主键与条件获取一条主题帖
     * @param $tid
     */
    public function getOnceTopic($tid)
    {
        $data =  $this->join('categories', 'topics.cid', '=', 'categories.cid')
            ->join('users', 'topics.uid', '=', 'users.uid')
            ->select('topics.*', 'categories.catname', 'categories.catdir', 'users.name', 'users.avstar', 'users.isadmin')
            ->where('users.status','=',1)
            ->find($tid);

        //是否存在数据
        if ($data) {
            return $data->attributes;
        }else{
            return false;
        }

    }

    /**
     * 获取指定排序的主题帖
     * @param $sortBy   排序字段
     * @param int $num 条数
     * @return mixed    返回的数据
     */
    public function getCustomTopics($sortBy, $num = 5)
    {
        $datas = $this->take($num)->orderBy($sortBy, 'desc')->get();
        return self::objectToArray($datas);
    }

    /**
     * 判断正文中是否包含图片
     * @param $content  正文内容
     * @return bool
     */
    public function isAssetImage($content)
    {
        return preg_match('/<img(.*)src=(.*)>/', $content);
    }

    /**
     * 将查询出的对象数据转换成数组
     * 注意: 必须是查询出多条数据才可以使用本方法
     * @param $objectData   查询出的对象数据
     * @return array    返回的二维数组
     */
    public static function objectToArray($objectData)
    {
        $arr = [];
        //二维
        foreach ($objectData as $row) {
            $arr[] = $row->attributes;
        };
        return $arr;
    }

    /**
     * 获取当前用户帖子
     */
    public static function getCurrentUserTopics($uid, $pageSize)
    {
        $data = self::join('categories', 'topics.cid', '=', 'categories.cid')
            ->join('users', 'topics.uid', '=', 'users.uid')
            ->select('topics.*', 'categories.catname', 'categories.catdir', 'users.name')
            ->where('topics.islook', '=', 1)
            ->where('topics.isshow', '=', 1)
            ->where('topics.uid', '=', $uid)
            ->orderBy('tid', 'desc')
            ->paginate($pageSize);
        return $data;
    }

    /**
     * 根据条件删除所有表中关联有当前帖子的数据
     * @param $topic    object    topic实例
     * @param $tid  integer     帖子id
     * @return bool  boolen     返回状态值
     */
    public static function deleteTopicAboutData($topic, $tid)
    {
        //删除主表数据
        $topicRs = $topic->delete();
        if ($topicRs === false) {
            return false;
        }
        //删除附表数据
        $topicDetailRs = DB::table('topic_details')->where('tid', $tid)->delete();
        if ($topicDetailRs === false) {
            return false;
        }
        //删除tid的回帖
        $commentRs = Comment::where('tid', $tid)->delete();
        if ($commentRs === false) {
            return false;
        }
        //删除收藏夹数据
        $collectionRs = \App\Collection::where('tid', $tid)->delete();
        if ($collectionRs === false) {
            return false;
        }

        return true;
    }

    /**
     * 根据关键词查询数据
     * @param $pageSize
     * @param $cid
     * @return mixed
     */
    public function getSearchData($pageSize, $keyword)
    {
        //主题帖查询结果
        return $this->where('topics.title', 'like', '%' . $keyword . '%')
            ->join('categories', function ($join) {
                $join->on('topics.cid', '=', 'categories.cid')
                    ->where('topics.islook', '=', 1)
                    ->where('topics.isshow', '=', 1);
            })
            ->join('users', 'topics.uid', '=', 'users.uid')
            ->select('topics.*', 'categories.catname', 'categories.catdir', 'users.name', 'users.avstar')
            ->orderBy('tid', 'desc')
            ->paginate($pageSize);
    }


}
