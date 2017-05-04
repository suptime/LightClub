<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Auth;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'uid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'mobile', 'qqnum', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    //验证规则
    public static $rules = [
        'mobile'=>'required|regex:/^1[3578]\d{9}$/',
        'qqnum'=>'regex:/^\d{5,10}$/',
        'password'=>'min:6|max:18',
        'repassword'=>'same:password|min:6|max:18',
        'signature'=>'max:100'
    ];
    public static $messages = [
        'required'=>':attribute不能为空',
        'regex'=>':attribute不合法',
        'unique'=>':attribute已存在',
        'min'=>':attribute太短',
        'same'=>':attribute不正确',
        'signature'=>':attribute太长',
        'confirmed'=>':attribute不正确',
    ];
    public static $names = [
        'mobile'=>'手机号码',
        'qqnum'=>'QQ号',
        'password'=>'密码',
        'repassword'=>'确认密码',
        'signature'=>'签名'
    ];

    /**
     * 根据用户积分获取用户等级
     * @param $grade    会员经验
     * @return int  会员等级
     */
    public static function getUserLevel($grade){
        //用户等级规则
        switch ($grade){
            case $grade >= 0 && $grade < 100:
                return 1;
                break;
            case $grade >= 100 && $grade < 500:
                return 2;
                break;
            case $grade >= 500 && $grade < 1500:
                return 3;
                break;
            case $grade >= 1500 && $grade < 3000:
                return 4;
                break;
            case $grade >= 5000 && $grade < 7000:
                return 5;
                break;
            case $grade >= 5000 && $grade < 7000:
                return 6;
                break;
            case $grade >= 7000 && $grade < 9000:
                return 7;
                break;
            case $grade >= 9000 && $grade < 15000:
                return 8;
                break;
            case $grade >= 15000 && $grade < 30000:
                return 9;
                break;
            case $grade >= 30000:
                return 10;
                break;
            default:
                return 1;
        }
    }

    /**
     * 根据用户id增加用户积分与经验
     * @param $uid  用户id
     */
    public static function setUserScore($uid)
    {
        $score = self::where('uid', $uid)->increment('score', 5);
        $grade = self::where('uid', $uid)->increment('grade', 20);
        if ($score == true && $grade == true){
            return true;
        }
        return false;
    }

    /**
     * 获取访问的会员信息
     * @param $uid
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function getVisitUserInfo($uid){
        //验证会员是否存在
        return self::select('uid','name','email','mobile','qqnum','score','grade','avstar','isadmin','status','signature')
            ->where('status',1)
            ->find($uid);
    }

    /**
     * 获取需要修改的用户数据
     * @param $uid
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function getUpdateUserData($uid){
        //验证会员是否存在
        return self::where('status',1)->find($uid);
    }

    /**
     * 获取已登录用户的消息通知状态
     */
    public static function getMsgStatus(){
        //获取当前登录用户的id
        $uid = Auth::id();
        //判断是否有未读系统通知
        $hasMsg = MessageUser::whereRaw('receive_uid = ? AND `read` = ?', [$uid, 0])->count();
        $hasLetter = Letter::whereRaw('receive_uid = ? AND `read` = ?', [$uid, 0])->count();

        //分享数据到所有视图
        view()->share('msgStatus', ['hasMsg' => $hasMsg, 'hasLetter' => $hasLetter]);
    }

}
