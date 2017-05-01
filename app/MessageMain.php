<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class MessageMain extends Model
{
    protected $table = 'message_main';
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
     * 新增一条系统通知消息或公告
     * @param $data
     */
    public function addOneMessage($data){
        $this->uid = $data['uid'];
        $this->msg_title = trim($data['msg_title']);
        $this->send_to = $data['send_to'];
        $this->msg_content = $data['msg_content'];

        //给所有用户分配消息
        $msgData['send_uid'] = $this->uid;

        //发送消息的对象未填写
        if (!$this->send_to){
            unset($this->send_to);
            $this->isall = 1;
            $rs = $this->save();
            $msgData['msg_id'] = $this->id;
            //保存数据到消息表中
            if ($rs && $this->insertMessageUserData($msgData)) {
                return true;
            }
        }else{
            //发送指定对象已填写
            $this->isall = 0;
            $this->send_to = $this->send_to = str_replace(' ', '', $this->send_to);
            //将收信人存入数据库中
            $rs = $this->save();
            $msgData['msg_id'] = $this->id;
            //插入数据到用户消息表中
            if ($rs && $this->getHasMsgUsers($this->send_to, $msgData)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 发送站内消息给指定的用户
     * @param $str
     * @param $data
     * @return mixed
     */
    public function getHasMsgUsers($str, $data){
        $msgUsers = explode('|', $str);
        //获取所有会员
        $users = User::select('uid','name','isadmin')->where('status',1)->get();
        $messageUserData = [];
        foreach ($users as $row){
            if (in_array($row->name, $msgUsers)){
                $messageUserData[] = [
                    'msg_id' => $data['msg_id'],
                    'send_uid' => $data['send_uid'],
                    'receive_uid' => $row->uid,
                    'created_at' => time(),
                ];
            }
        }

        //将数据保存到用户消息表中
        return MessageUser::insert($messageUserData);
    }

    /**
     * 保存消息记录到用户消息表中
     * @param $data
     */
    public function insertMessageUserData($data){
        //获取所有会员
        $users = User::select('uid','name','isadmin')->where('status',1)->get();
        //定义数据准备数组
        $msgUserData = [];
        foreach ($users as $u){
            $msgUserData[] = [
                'msg_id' => $data['msg_id'],
                'send_uid' => $data['send_uid'],
                'receive_uid' => $u->uid,
                'created_at' => time(),
            ];
        }
        //将数据保存到用户消息表中
        return MessageUser::insert($msgUserData);
    }


    /**
     * 根据条件获取消息列表
     * @param $msg_type
     * @param $pageSize
     * @return mixed
     */
    public static function getMsgList($pageSize){
        return self::join('users', 'message_main.uid', '=', 'users.uid')
            ->select('message_main.*', 'users.name')
            ->orderBy('created_at', 'desc')
            ->paginate($pageSize);
    }


}
