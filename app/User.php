<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

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


    /**
     * 根据用户积分获取用户等级
     * @param $grade    会员经验
     * @return int  会员等级
     */
    public static function getUserLevel($grade){
        //用户等级规则
        //0-100 LV1  100-500 LV2  500-1500 LV3  1500-3000 LV4  5000+ VL5
        switch ($grade){
            case $grade >= 0 && $grade <= 100:
                return 1;
                break;
            case $grade >= 100 && $grade <= 500:
                return 2;
                break;
            case $grade >= 500 && $grade <= 1500:
                return 3;
                break;
            case $grade >= 1500 && $grade <= 3000:
                return 4;
                break;
            case $grade >= 5000:
                return 5;
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

}
