<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 注册登录控制器
    |--------------------------------------------------------------------------
    |
    | 这个控制器处理新用户的注册，以及
    |现有用户认证。默认情况下，该控制器使用
    |简单添加这些行为特质。你为什么不探索一下呢？
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    //字段配合登陆的字段
    protected $username = 'name';
    //登陆成功后的跳转方向
    protected $redirectPath = 'user/collection';
    //默认退出后跳转页
    protected $redirectAfterLogout = '/';
    //默认登陆 URL
    protected $loginPath = 'user/login';

    /**
     * 创建一个新的身份验证控制器实例。
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * 得到一个接收注册请求验证器
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $capcha = session()->get('challenge');
        return  Validator::make($data, [
            'name' => 'required|min:6|max:20',
            'email' => 'required|email|max:255|unique:users',
            'mobile' => 'required|regex:/^1[3578]\d{9}$/|unique:users',
            'password' => 'required|min:6|max:18',
            'repassword' => 'required|same:password',
            'geetest_challenge' => 'required|regex:/'.$capcha.'.*/',
        ],[
            'required'=> ':attribute不能为空',
            'max'=> ':attribute过长',
            'email'=> ':attribute格式不正确',
            'unique'=> ':attribute已被占用',
            'regex'=> ':attribute格式不正确',
            'min'=> ':attribute太短',
            'same'=> ':attribute校验失败',
            'regex'=> config('geetest.server_fail_alert'),
        ],[
            'name' => '用户名',
            'email' => '邮箱',
            'mobile' => '手机号码',
            'password' => '密码',
            'repassword' => '验证密码',
        ]);
    }

    /**
     * 在有效注册后创建新用户实例。
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
            'repassword' => bcrypt($data['repassword'])
        ]);
    }
}
