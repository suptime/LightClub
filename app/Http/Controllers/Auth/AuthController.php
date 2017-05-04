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
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    //字段配合登陆的字段
    protected $username = 'name';
    //登陆成功后的跳转方向
    protected $redirectPath = '/';
    //默认退出后跳转页
    protected $redirectAfterLogout = '/';
    //默认登陆 URL
    protected $loginPath = 'user/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|min:6|max:20',
            'email' => 'required|email|max:255|unique:users',
            'mobile' => 'required|regex:/^1[3578]\d{9}$/|unique:users',
            'password' => 'required|min:6|max:18',
            'repassword' => 'required|same:password',
        ],[
            'required'=> ':attribute不能为空',
            'max'=> ':attribute过长',
            'email'=> ':attribute格式不正确',
            'unique'=> ':attribute已被占用',
            'regex'=> ':attribute格式不正确',
            'min'=> ':attribute太短',
            'same'=> ':attribute校验失败',
        ],[
            'name' => '用户名',
            'email' => '邮箱',
            'mobile' => '手机号码',
            'password' => '密码',
            'repassword' => '验证密码',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
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
            'repassword' => bcrypt($data['repassword']),
        ]);
    }
}
