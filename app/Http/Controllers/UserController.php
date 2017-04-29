<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class UserController extends Controller
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    //字段配合登陆的字段
    protected $username = 'name';
    //登陆成功后的跳转方向
    protected $redirectPath = '/user/home';
    //默认退出后跳转页
    protected $redirectAfterLogout = '/';
    //默认登陆 URL
    protected $loginPath = 'user/login';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:20',
            'email' => 'required|email|max:255|unique:users',
            'mobile' => 'required|regex:/^1[3578]\d{9}$/|unique:users',
            'password' => 'required|min:6',
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


    /**
     * 会员首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function main(){
      return view('auth.user');
    }
}
