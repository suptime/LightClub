<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{

    protected $table = 'letters';
    protected $primaryKey = 'id';
    public $timestamps = false;


    /**
     * 获取发送给本用户私信的用户信息
     * @param $uid
     * @return array
     */
    public static function getLettersList($uid){
        $data = self::where('receive_uid','=', $uid)->orWhere('send_uid', '=', $uid)->orderBy('created_at')->lists('send_uid','receive_uid')->toArray();
        $data = array_merge(array_keys($data), array_values($data));
        $data = array_unique($data);
        //删除自己
        foreach ($data as $k => $v){
            if ($v == $uid){
                unset($data[$k]);
            }
        }
        //查询对应的用户信息
        $data = User::select('uid', 'name', 'avstar')->where('status','=', 1)->whereIn('uid', $data)->get();
        return $data;
    }

    //根据发送者的uid获取发给当前登录用户消息详细
    public static function getSendUserLetters($uids){
        self::markReaded($uids);    //将现存的数据库消息设置为已读
        $data = self::whereIn('send_uid',$uids)->whereIn('receive_uid',$uids)->get()->toArray();
        $letters = [];
        foreach ($data as $row){
            $letters[] = [
                'id' => $row['id'],
                'send_uid' => $row['send_uid'],
                'receive_uid' => $row['receive_uid'],
                'read' => $row['read'],
                'letter' => $row['letter'],
                'created_at' => date('Y-m-d H:i:s', $row['created_at'])
            ];
        }
        return $letters;
    }

    /**
     * 根据条件删除数据
     * @param $uids
     * @return mixed
     */
    public static function deleteConversationData($uids){
        self::markReaded($uids);    //将现存的数据库消息设置为已读
        return self::whereIn('send_uid',$uids)->whereIn('receive_uid',$uids)->delete();
    }

    /**
     * 将数据库消息设置为已读
     * @param $uids
     * @return mixed
     */
    public static function markReaded($uids){
        return self::whereIn('send_uid',$uids)->whereIn('receive_uid',$uids)->where('read','<>',1)->update(['read'=> 1]);
    }
}
