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
            <h2 class="form-title text-center" style="padding: 30px 0">新用户注册</h2>
            <div class=" col-md-6 col-md-offset-3">
                {{ csrf_field() }}
                <div class="form-group">
                    <input class="form-control required" type="text" placeholder="用户名" name="name" autofocus="autofocus"/>
                    <?php echo $errors->first('name'); ?>
                </div>
                <div class="form-group">
                    <input class="form-control required" type="text" placeholder="手机号码" name="mobile" autofocus="autofocus"/>
                    <?php echo $errors->first('mobile'); ?>
                </div>
                <div class="form-group">
                    <input class="form-control required" type="password" placeholder="密码" id="password" name="password"/>
                    <?php echo $errors->first('password'); ?>
                </div>
                <div class="form-group">
                    <input class="form-control required" type="password" placeholder="重复密码" name="repassword"/>
                    <?php echo $errors->first('repassword'); ?>
                </div>
                <div class="form-group">
                    <input class="form-control eamil" type="text" placeholder="邮箱" name="email"/>
                    <?php echo $errors->first('email'); ?>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" style="width: 100%" value="新用户注册"/>
                </div>
                <div class="form-group text-center">
                    <a href="{{ url('user/login') }}">已有账号? 点这里登录</a>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>