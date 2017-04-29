<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>用户注册</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</head>
<body>
<div class="container">
    <div class="form row">
        <form class="form-horizontal col-md-6 col-md-offset-3" action="" method="post" id="register_form">
            <h2 class="form-title text-center" style="padding: 30px 0">用户登录</h2>
            <div class=" col-md-6 col-md-offset-3">
                {{ csrf_field() }}
                <div class="form-group">
                    <input class="form-control required" type="text" placeholder="用户名" name="name" autofocus="autofocus"/>
                    {{ $errors->first('name') ? '用户名不正确' : '' }}
                </div>
                <div class="form-group">
                    <input class="form-control required" type="password" placeholder="密码" id="password" name="password"/>
                    {{ $errors->first('password') ? '密码不正确' : '' }}
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" style="width: 100%" value="用户登录"/>
                </div>
                <div class="form-group text-center">
                    <a href="{{ url('user/register') }}">没有账号? 去注册一个</a>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>