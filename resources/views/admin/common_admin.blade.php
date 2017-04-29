<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!-- Bootstrap CSS 文件 -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    @section('style')

    @show
</head>
<body>

<!-- 头部 -->
@section('header')
    <nav class="navbar navbar-inverse navbar-collapse" style="border-radius: 0">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ url('admin/main') }}">轻社区后台管理面板</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">自定义菜单1 <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">自定义菜单2</a></li>
                </ul>
                {{--<form class="navbar-form navbar-left">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">搜索</button>
                </form>--}}
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{url('/')}}" target="_blank">查看首页</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">我的主页</a></li>
                            <li><a href="#">资料设置</a></li>
                            <li><a href="#">站内私信</a></li>
                            <li><a href="#">退出登录</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
@show

<!-- 中间内容区局 -->
<div class="container-fluid" style="margin-top:20px;">
    <div class="row">

        <!-- 左侧菜单区域   -->
        <div class="col-md-2">
            @section('leftmenu')
                <div class="list-group">
                    <div class="list-group-item disabled" style="font-size: 20px">管理菜单</div>
<a href="{{ url('admin/category/list') }}" class="list-group-item {{ Request::getPathInfo() != '/admin/category/list' ? '' : 'active'}}">主题分类</a>
<a href="{{ url('admin/topic/list') }}" class="list-group-item {{ Request::getPathInfo() != '/admin/topic/list' ? '' : 'active'}}">帖子管理</a>
<a href="" class="list-group-item">回帖管理</a>
<a href="" class="list-group-item">用户列表</a>
<a href="" class="list-group-item">系统设置</a>
                </div>
            @show
        </div>

        <!-- 右侧内容区域 -->
        <div class="col-md-10">

           @yield('content')

        </div>
    </div>
</div>

<!-- 尾部 -->
@section('footer')

@show

<!-- jQuery 文件 -->
<script src="https://cdn.bootcss.com/jquery/1.11.1/jquery.js"></script>
<!-- Bootstrap JavaScript 文件 -->
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

@section('script')

@show
</body>
</html>