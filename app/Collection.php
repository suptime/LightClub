<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collections';
    protected $primaryKey = 'id';
    public $timestamps = true;

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
     * 根据帖子id与当前登录用户id获取收藏状态
     * @param $tid
     * @param $uid
     * @return mixed
     */
    public static function getCollectionStatus($tid, $uid){
        return Collection::where('tid',$tid)->where('uid',$uid)->count();
    }

    /**
     * 根据条件删除收藏数据
     * @param $tid
     * @param $uid
     * @return mixed
     */
    public static function deletCollection($tid, $uid=''){
        if ($uid){
            $data = Collection::whereRaw('tid = ? AND uid = ?',[$tid, $uid])->first();
        }else{
            $data = Collection::where('tid',$tid)->first();
        }
       return $data->delete();
    }


    /**
     * 获取用户的所有收藏
     * @param $uid
     * @param $pageSize
     */
    public static function getCollectionList($uid, $pageSize){
        return self::join('topics', 'topics.tid', '=', 'collections.tid')
            ->select('collections.*', 'topics.title', 'topics.islook', 'topics.isshow', 'topics.reply_total', 'topics.click')
            ->where('collections.uid',$uid)
            ->where('topics.islook','=',1)
            ->where('topics.isshow', '=',1)
            ->orderBy('created_at', 'desc')
            ->paginate($pageSize);
    }
}
