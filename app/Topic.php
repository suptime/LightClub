<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{

    protected $table = 'topics';

    protected $primaryKey = 'tid';

    protected $fillable = ['title', 'content', 'tags',];

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
     * 列表页获取主题信息
     * @param integer $pageSize 每页显示数量
     * @param string $cid   分类id
     * @param string $orderBy   排序方式
     * @return array & object mixed    对象或数组
     */
    public function getAllTopic($pageSize, $cid='', $orderBy = 'created_at', $platform=''){
        if ($platform == 'admin'){
            return $this->join('categories', 'topics.cid', '=', 'categories.cid')
                ->join('users', 'topics.uid', '=', 'users.uid')
                ->select('topics.*', 'categories.catname', 'categories.catdir', 'users.name', 'users.avstar')
                ->orderBy($orderBy,'desc')
                ->paginate($pageSize);
        }

        if (!$cid) {
            //首页主题帖查询结果
            $data =  $this->join('categories', function ($join) use ($cid){
                    $join->on('topics.cid', '=', 'categories.cid')
                        ->where('topics.islook','=',1)
                        ->where('topics.isshow', '=',1);
                })
                ->join('users', 'topics.uid', '=', 'users.uid')
                ->select('topics.*', 'categories.catname', 'categories.catdir', 'users.name', 'users.avstar')
                ->orderBy($orderBy,'desc')
                ->paginate($pageSize);
        }else{
            //列表页主题查询结果,带指定条件的查询
            $data =  $this->join('categories', function ($join) use ($cid){
                                                $join->on('topics.cid', '=', 'categories.cid')
                                                ->where('topics.cid','=',$cid)
                                                ->where('topics.islook','=',1)
                                                ->where('topics.isshow', '=',1);
                                            })
                ->join('users', 'topics.uid', '=', 'users.uid')
                ->select('topics.*', 'categories.catname', 'categories.catdir', 'users.name', 'users.avstar')
                ->orderBy($orderBy,'desc')
                ->paginate($pageSize);
        }
        return $data;
    }


    /**
     * 根据主键与条件获取一条主题帖
     * @param $tid
     */
    public function getOnceTopic($tid){
        return $this->join('categories', 'topics.cid', '=', 'categories.cid')
            ->join('users', 'topics.uid', '=', 'users.uid')
            ->select('topics.*', 'categories.catname', 'categories.catdir', 'users.name', 'users.avstar', 'users.isadmin')
            ->find($tid)->attributes;
    }

    /**
     * 获取指定排序的主题帖
     * @param $sortBy   排序字段
     * @param int $num  条数
     * @return mixed    返回的数据
     */
    public function getCustomTopics($sortBy,$num = 5){
        $datas = $this->take($num)->orderBy($sortBy,'desc')->get();
        return self::objectToArray($datas);
    }

    /**
     * 判断正文中是否包含图片
     * @param $content  正文内容
     * @return bool
     */
    public function isAssetImage($content){
        return preg_match('/<img(.*)src=(.*)>/', $content);
    }

    /**
     * 将查询出的对象数据转换成数组
     * 注意: 必须是查询出多条数据才可以使用本方法
     * @param $objectData   查询出的对象数据
     * @return array    返回的二维数组
     */
    public static function objectToArray($objectData){
        $arr = [];
        //二维
        foreach($objectData as $row){
            $arr[] = $row->attributes;
        };
        return $arr;
    }
}
