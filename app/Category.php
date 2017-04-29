<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //定义状态常量
    const IS_SHOW  = 1;
    const IS_HIDDEN = 0;
    const IS_CHANNEL = 1;
    const IS_LIST = 0;

    //设置表信息
    protected $table = 'categories';
    protected $primaryKey = 'cid';
    public $timestamps = false;

    //设置允许完成字段
    protected $fillable = [
        'catname', 'parent_id', 'catdir', 'keywords', 'description', 'status', 'ischannel'
    ];


    //数据验证

    public $rules = [
        'parent_id' => 'required|integer',
        'catname' => 'required|max:20',
        'catdir' => 'required|alpha_dash',
        'status' => 'required|in:0,1',
        'ischannel' => 'required|in:0,1',
    ];

    public $messages = [
        'required' => ':attribute为必填项',
        'integer' => ':attribute只能是整数数字',
        'max' => ':attribute超出最大长度',
        'alpha_dash' => ':attribute只能是数字字母_-组合',
        'in' => ':attribute不是合法值',
    ];

    public $attrs = [
        'parent_id' => '上级分类',
        'catname' => '分类名称',
        'catdir' => '分类路径',
        'status' => '显示状态',
        'ischannel' => '分类属性',
    ];


    /**
     * 根据状态值显示类型
     * @param $type string  状态类型
     * @param null $integer  integer   类型值,取值范围为0,1
     * @return array|mixed      返回数组或字符串
     */
    public function getStatus($type, $integer = null){

        //判断类型
        if ($type == 'status') {
            $arr = [
                self::IS_SHOW => '显示',
                self::IS_HIDDEN => '隐藏',
            ];

        }

        if( $type == 'channel' ){
            $arr = [
                self::IS_CHANNEL => '频道',
                self::IS_LIST => '列表',
            ];
        }

        //判断是否已指定类型值
        if ($integer !== null){
            return $arr[$integer];
        }

        //没有指定类型值返回全部数据
        return $arr;
    }


    /**
     * 获取所有 分类
     * @return mixed array  cid => catname 格式
     */
    public function getCateTree(){
        return $this->lists('catname','cid');
    }
}
