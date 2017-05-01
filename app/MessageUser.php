<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageUser extends Model
{
    protected $table = 'message_user';
    protected $primaryKey = 'id';
    protected $fillable = ['id','uid', 'msg_id', 'read', 'created_at'];
    public $timestamps = false;


    /**
     * 获取当前登录用户的系统消息列表
     * @param $pageSize
     * @return mixed
     */
    public static function getSystemMessageData($uid, $pageSize){
        return self::join('message_main', 'message_user.msg_id', '=', 'message_main.id')
            ->select('message_user.*', 'message_main.msg_title', 'message_main.msg_content')
            ->where('message_user.receive_uid', '=', $uid)
            ->orderBy('created_at', 'desc')
            ->paginate($pageSize);
    }
}
