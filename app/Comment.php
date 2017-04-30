<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['comment', 'tid', 'uid', 'at', 'pid']; //允许批量赋值字段

    /**
     * 填充时间为时间戳
     * @return int
     */
    protected function getDateFormat()
    {
        return time();
    }

    /**
     * 将时间戳原样返回,不格式化
     * @param mixed $value
     * @return mixed
     */
    protected function asDateTime($value)
    {
        return $value;
    }

    /**
     * 获取所有回帖数据
     * @param $tid
     * @param string $pageSize
     * @return array
     */
    public static function getCommentsAndUsers($tid, $pageSize = '')
    {
        $data = self::join('users', 'comments.uid', '=', 'users.uid')
            ->select('comments.*', 'users.name', 'users.score', 'users.grade', 'users.avstar', 'users.isadmin', 'users.status')
            ->where('comments.tid', '=', $tid)
            ->where('users.status', '<>', '-1')
            ->where('comments.is_show', '=', 1)
            ->orderBy('id', 'asc')
            ->get();

        //将对象转换成数组
        $data = Topic::objectToArray($data);
        return $data;
    }


    /**
     * 根据传入的pid删除对应子回复
     * @param $pid
     */
    public static function deleteSonComment($pid)
    {
        //查询是否存在子数据
        $count = self::where('pid', $pid)->count();
        if (!$count) {
            return true;
        }
        //删除评论
        return self::where('pid', $pid)->delete();
    }

    /**
     * 统计每条帖子的回复总数
     * @param $tid
     * @return mixed
     */
    public static function getCountComment($tid)
    {
        //统计回复数
        $num = self::where('tid', $tid)->count();
        $num = $num ? $num : 0;
        //更新
        Topic::where('tid', $tid)->update(['reply_total' => $num]);
    }
}
