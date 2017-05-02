<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<title>@yield('title','laravel轻社区')</title>
<meta name="keywords" content="@yield('keywords','laravel轻社区')">
<meta name="description" content="@yield('description','laravel轻社区')">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/layout.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugs/layui/css/layui.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forums.css') }}" />
@section('style')
@show
</head>

<body>
<!--top s-->
<div class="top">
    <div class="content mini-bar">
        <a href=""><i class="k-i-home"></i> <span>欢迎来到豆萌社区</span></a>
        <div class="right-user">
            @if(!Auth::check())
            <a href="{{url('user/login')}}">登录</a>
            <a class="cut-off">|</a>
            <a href="{{url('user/register')}}">注册</a>
            @else
            <a href="{{ url('user/letters') }}" class="header-im-show">
                <i class="kz-e-envelope"></i>
                <span class="header-notice-point"></span>
            </a>
            <a href="{{ url('user/notice') }}" class="header-notice-show" title="系统消息">
                <i class="k-i-remind"></i>
                <span class="header-notice-point"></span>
            </a>
            <div class="header-user-content" id="user-status">
                <div class="header-avatar-content"><img src="{{ Auth::user()->avstar ? Auth::user()->avstar : asset('assets/img/default.jpg') }}" /></div>
                <div class="header-name-content">
                    <span>{{Auth::user()->name}}</span>
                    <span id="user-arrow" class="header-arrow"></span>
                </div>
                <div class="header-user-all header-menu" id="user-menu">
                    <a href="{{url('space/'. Auth::id())}}">我的主页</a>
                    <a href="{{url('reply/'. Auth::id())}}">我的回复</a>
                    <a href="{{url('user/collection')}}">我的收藏</a>
                    <a href="{{url('user/setting')}}">个人设置</a>
                    <a href="{{url('user/logout')}}">退出账号</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<!--top e-->
<!--search & nav s-->
<div class="header">
    <div class="content">
        <div class="logo-search-section">
            <div href="javascript:void(0)" class="site-section">
                <a href="{{url('/')}}"><span class="logo-title"><img src="{{asset('assets/img/logo.png')}}" /></span></a>
            </div>
            <!--search s-->
            <div class="search-section">
                <div class="search-form">
                    <div class="search-pop-form"><input type="text" placeholder="请输入搜索内容" value=""></div>
                    <a href="javascript:void(0)"><i class="k-i-search search-icon"></i></a>
                </div>
            </div>
            <!--search e-->
        </div>
        <!--nav s-->
        <div class="nav-tag">
            <ul class="all-tags">
                <li class="{{ Request::getPathInfo() == '/' ? 'tag-cur' : '' }}"><a href="{{url('/')}}">网站首页</a></li>
                @foreach($navs as $val)
                    <li class="{{ Request::getPathInfo() == '/'.$val['catdir'] || (isset($topic['cid']) && $topic['cid'] == $val['cid']) ? 'tag-cur' : '' }}"><a href="{{url($val['catdir'])}}">{{ $val['catname'] }}</a></li>
                @endforeach
            </ul>
        </div>
        <!--nav e-->
    </div>
</div>
<!--search & nav e-->
@if( Session::has('success') )
<div class="content message-tips">
    <div class="Huialert Huialert-success"><span class="icon-remove">×</span>{{ Session::get('success') }}</div>
</div>
@endif
@if( Session::has('error') )
    <div class="content message-tips">
        <div class="Huialert Huialert-danger"><span class="icon-remove">×</span>{{ Session::get('error') }}</div>
    </div>
@endif
<!--forumContent s-->
<div class="forum-content content">
    <div class="forum-content-left">
        @yield('left')

        @section('editor')
        <!--editor s-->
        <div class="editor-main">
            <div class="box-title">发布话题</div>
            <div class="editor-content">
                <form action="{{ url('topic/add') }}" method="post">
                    {{ csrf_field() }}
                    <div class="put-select">
                        <input type="hidden" id="cateogry" name="cid" value="0" />
                        <div id="form-category">
                            <div id="cate-current">选择分类</div>
                            <div id="cate-ids" style="display: none">
                                @foreach($navs as $val)
                                    <a data-cid="{{$val['cid']}}">{{ $val['catname'] }}</a>
                                @endforeach
                            </div>
                        </div>
                        <input class="topic-title-input" type="text" name="title" placeholder="填写将要发布的主题标题" />
                        {{$errors->first('cid')}} {{$errors->first('title')}}
                    </div>
                    <div class="editor-pub-content">
                        {{$errors->first('content')}}
                        <textarea class="tinyce-editor" name="content" id="editor-content" style="display: none;"></textarea>
                    </div>

                    <input type="hidden" id="tags" name="tags" value="" />
                    <button class="editor-pub-button" type="submit"><i class="k-i-edit"></i><span class="pub-text">发表新话题</span></button>
                </form>
            </div>
        </div>
        <!--editor e-->
        @show
    </div>

    <!--侧栏 s-->
    <div class="forum-content-right">
        @section('right')

        @show
    </div>
    <!--侧栏 s-->
</div>
<!--forumContent e-->

@section('footer')
<div class="footer content">
    <span>© 2017 豆萌社区</span>
    <a href="" target="_blank">注册协议</a> |
    <a href="" target="_blank">关于我们</a> |
    <a class="ueg_feedback-link" href="" target="_blank">意见反馈</a> |
    <a href="" target="_blank">网络谣言警示</a>
</div>
<script src="https://cdn.bootcss.com/jquery/1.11.1/jquery.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugs/layui/layui.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/common.js') }}"></script>
@show
@section('script')
@show
</body>
</html>
