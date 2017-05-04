<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>新用户注册 - {{ $configs['site_name'] }} </title>
<link rel="stylesheet" href="{{ asset('assets/css/register-login.css') }}"/>
</head>
<body>
<div id="box"></div>
<div class="cent-box register-box">
    <div class="cent-box-header">
        <h1 class="main-title hide" onclick="window.open('{{ url('/') }}', '_self')">SimpleBBS</h1>
        <h2 class="sub-title">生活热爱分享 - I have a dream</h2>
    </div>

    <div class="cont-main clearfix">
        <div class="index-tab">
            <div class="index-slide-nav">
                <a href="{{ url('user/login') }}">登录</a>
                <a href="{{ url('user/register') }}" class="active">注册</a>
                <div class="slide-bar slide-bar1"></div>
            </div>
        </div>

        <form action="" method="post">
            {{ csrf_field() }}
            <div class="login form">
                <div class="group">
                    <div class="group-ipt name">
                        <input type="text" name="name" id="name" lay-verify="required" class="ipt" placeholder="用户名" required>
                        <label class="error is-visible">{{ $errors->first('name') }}</label>
                    </div>
                    <div class="group-ipt password"><input type="text" id="mobile" name="mobile" lay-verify="required" class="ipt input-border" placeholder="11位手机号码" required>
                        <label class="error is-visible">{{ $errors->first('mobile') }}</label>
                    </div>
                    <div class="group-ipt password"><input type="text" id="email" name="email" lay-verify="required" class="ipt input-border" placeholder="邮箱" required>
                        <label class="error is-visible">{{ $errors->first('email') }}</label>
                    </div>
                    <div class="group-ipt password"><input type="password" id="password" name="password" lay-verify="required" class="ipt input-border" placeholder="登录密码" required>
                        <label class="error is-visible">{{ $errors->first('password') }}</label>
                    </div>
                    <div class="group-ipt password"><input type="password" id="repassword" name="repassword" lay-verify="required" class="ipt input-border" placeholder="确认密码" required>
                        <label class="error is-visible">{{ $errors->first('repassword') }}</label>
                    </div>
                    <div class="group-ipt verify"><input type="text" id="verify" name="verify" class="ipt input-border" placeholder="输入验证码"><img src="{{ url('assets/img/captcha.gif') }}" class="imgcode">
                    </div>
                </div>
            </div>
            <div class="button">
                <button type="submit" class="login-btn register-btn" id="button">新用户注册</button>
            </div>
        </form>
    </div>
</div>

<div class="footer">
    <p>&copy; 2017 豆萌社区</p>
</div>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/particles.min.js') }}"></script>
<script type="text/javascript">
    $('.imgcode').click(function () {
        $(this).attr('src', '{{ asset('assets/img/captcha.gif') }}?id=' + Math.random());
    });
    $("#remember-me").click(function () {
        var n = document.getElementById("remember-me").checked;
        if (n) {
            $(".zt").show();
        } else {
            $(".zt").hide();
        }
    });
</script>
</body>
</html>

