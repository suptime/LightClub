<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','后台控制面板')</title>
    <link rel="stylesheet" href="{{ asset('assets/plugs/layui/css/layui.admin.min.css') }}">
    @section('style')

    @show
</head>
<body>
<div class="layui-layout-admin">
<!-- 头部 -->
@section('header')
<div class="header" style="position: fixed;top: 0; width: 100%; z-index: 100000">
<ul class="layui-nav" style="padding: 0">
    <div style="float: right">
        <li class="layui-nav-item"><a href="{{ url('/') }}" target="_blank">访问首页</a></li>
        <li class="layui-nav-item"><a href="{{ url('space/'. Auth::id()) }}" target="_blank"><i class="layui-icon">&#xe612;</i> {{ Auth::user()->name }}</a></li>
        <li class="layui-nav-item"><a href="{{ url('user/logout') }}">退出</a></li>
    </div>

    <li class="layui-nav-item" style="width: 150px; text-align: center">豆萌社区管理面板</li>
    {{--<li class="layui-nav-item layui-this">
        <a href="javascript:;">菜单</a>
        <dl class="layui-nav-child">
            <dd><a href="">选项1</a></dd>
            <dd><a href="">选项2</a></dd>
            <dd><a href="">选项3</a></dd>
        </dl>
    </li>--}}
</ul>
</div>
@show
<!-- 中间内容区局 -->
<div class="layui-main">
    <div class="layui-bg-black layui-side" style="position: fixed;width: 150px;">
    @section('leftmenu')
        <div class="layui-side-scroll">
        <ul class="layui-nav layui-nav-tree" lay-filter="demo" style="width: 150px;">
            <li class="layui-nav-item layui-nav-itemed">
                <a href="javascript:;"><i class="layui-icon">&#xe629;</i> 文档管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="{{ url('admin/category/list') }}" class="{{ Request::getPathInfo() != '/admin/category/list' ? '' : 'layui-this'}}"><i class="layui-icon">&#xe622;</i> 栏目分类</a></dd>

                    <dd><a href="{{ url('admin/topic/list') }}" class="{{ Request::getPathInfo() != '/admin/topic/list' ? '' : 'layui-this'}}"><i class="layui-icon">&#xe621;</i> 帖子管理</a></dd>

                    <dd><a href="{{ url('admin/comments/list') }}" class="{{ Request::getPathInfo() != '/admin/comments/list' ? '' : 'layui-this'}}"><i class="layui-icon">&#xe611;</i> 回帖管理</a></dd>

                    <dd><a href="{{ url('admin/collections/list') }}" class="{{ Request::getPathInfo() != '/admin/collections/list' ? '' : 'layui-this'}}"><i class="layui-icon">&#xe600;</i> 收藏管理</a></dd>

                    <dd><a href="{{ url('admin/users/list') }}" class="{{ Request::getPathInfo() != '/admin/users/list' ? '' : 'layui-this'}}"><i class="layui-icon">&#xe612;</i> 用户管理</a></dd>

                    <dd><a href="{{ url('admin/message/list') }}" class="{{ Request::getPathInfo() != '/admin/message/list' ? '' : 'layui-this'}}"><i class="layui-icon">&#xe63a;</i> 站内通知</a></dd>
                </dl>
            </li>

            <li class="layui-nav-item layui-nav-itemed">
                <a href="javascript:;"><i class="layui-icon">&#xe614;</i> 系统设置</a>
                <dl class="layui-nav-child">
                    <dd><a href="{{ url('admin/config') }}" class="{{ Request::getPathInfo() != '/admin/config' ? '' : 'layui-this'}}"><i class="layui-icon">&#xe631;</i> 基本信息</a></dd>
                    <dd><a href=""><i class="layui-icon">&#xe609;</i> 邮件设置</a></dd>
                    <dd><a href=""><i class="layui-icon">&#xe63a;</i> 微信公众号</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="javascript:;"><i class="layui-icon">&#xe60b;</i> 关于系统</a></li>
        </ul>
        </div>
    @show
    </div>

    <div class="layui-right" style=" margin: 20px 20px 20px 170px;">
        @yield('content')
    </div>

</div>

<!-- 尾部 -->
@section('footer')

@show
</div>
<script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugs/layui/layui.js') }}"></script>
<script type="text/javascript">
layui.use('element', function(){
    var element = layui.element(); //导航的hover效果、二级菜单等功能，需要依赖element模块
});
</script>

@section('script')

@show
</body>
</html>