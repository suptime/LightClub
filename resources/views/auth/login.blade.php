<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>用户登录 - {{ $configs['site_name'] }} </title>
<link rel="stylesheet" href="{{ asset('assets/css/register-login.css') }}"/>
</head>
<body>
<div id="box"></div>
<div class="cent-box">
    <div class="cent-box-header">
        <h1 class="main-title hide" onclick="window.open('{{ url('/') }}', '_self')">SimpleBBS</h1>
        <h2 class="sub-title">生活热爱分享 - I have a dream</h2>
    </div>

    <div class="cont-main clearfix">
        <div class="index-tab">
            <div class="index-slide-nav">
                <a href="{{ url('user/login') }}" class="active">登录</a>
                <a href="{{ url('user/register') }}">注册</a>
                <div class="slide-bar"></div>
            </div>
        </div>

        <form action="" method="post">
            {{ csrf_field() }}
        <div class="login form">
            <div class="group">
                <div class="group-ipt name">
                    <input type="text" name="name" id="name" lay-verify="required" class="ipt" placeholder="用户名" required>
                    <label class="error is-visible">{{ $errors->first('name') ? '用户名不正确' : '' }}</label>
                </div>
                <div class="group-ipt password">
                    <input type="password" id="password" name="password" lay-verify="required" class="ipt input-border" placeholder="登录密码" required>
                    <label class="error is-visible">{{ $errors->first('password') ? '密码不正确' : '' }}</label>
                </div>
                <div class="group-ipt verify">
                    <input type="text" id="verify" name="verify" class="ipt input-border" placeholder="输入验证码"><img src="{{ url('assets/img/captcha.gif') }}" class="imgcode">
                </div>
            </div>
        </div>
        <div class="button"><button type="submit" class="login-btn register-btn" id="button">登录</button></div>
        </form>

        <div class="remember clearfix">
            <label class="remember-me"><span class="icon"><span class="zt"></span></span>
                <input type="checkbox" name="remember-me" id="remember-me" class="remember-mecheck" checked>记住我</label>
            <label class="forgot-password"><a href="#">忘记密码？</a></label>
        </div>
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