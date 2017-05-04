@extends('admin.common_admin')
@section('content')
    <div class="mbnav">
        <span class="layui-breadcrumb"><a href="{{ url('admin/index') }}">首页</a> <a><cite>系统设置</cite></a></span>
    </div>

    @include('layout.message')
<form class="layui-form" method="post" action="">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $system_config->id }}">
    <div class="layui-form-item">
        <label class="layui-form-label">域名</label>
        <div class="layui-input-inline">
            <input type="text" name="domain" lay-verify="required" value="{{ $system_config->domain }}" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">网站域名,需要加上 http:// 或 https://</div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">网站名称</label>
        <div class="layui-input-inline">
            <input type="text" name="site_name" lay-verify="required" value="{{ $system_config->site_name }}" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">当前网站的名称</div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">关键词</label>
        <div class="layui-input-block">
            <input type="text" name="keywords" value="{{ $system_config->keywords }}" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">网站描述</label>
        <div class="layui-input-block">
            <textarea name="description" class="layui-textarea" id="description">{{ $system_config->description }}</textarea>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">社区公告</label>
        <div class="layui-input-block">
            <textarea name="announcement" class="layui-textarea" id="announcement">{{ $system_config->announcement }}</textarea>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">网站版权</label>
        <div class="layui-input-block">
            <textarea name="copyright" class="layui-textarea" id="copyright">{{ $system_config->copyright }}</textarea>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">分页大小</label>
        <div class="layui-input-inline">
            <input type="text" name="pagesize" lay-verify="required|number" value="{{ $system_config->pagesize }}" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">请填写数字</div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">运营状态</label>
        <div class="layui-input-inline">
            @if($system_config->site_status)
                <input type="radio" name="site_status" value="1" title="开启" checked>
                <input type="radio" name="site_status" value="0" title="关闭">
            @else
                <input type="radio" name="site_status" value="1" title="开启">
                <input type="radio" name="site_status" value="0" title="关闭" checked>
            @endif
        </div>
        <div class="layui-form-mid layui-word-aux">请慎重选择,否则网站无法正常访问</div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

@stop

@section('script')
<script>
layui.use(['form'], function(){
    var form = layui.form()
        ,layer = layui.layer;
    //自定义验证规则
    form.verify({
        title: function(value){
            if(value.length < 5){
                return '标题至少得5个字符啊';
            }
        }
    });
});
</script>
@stop