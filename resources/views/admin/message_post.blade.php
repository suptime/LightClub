@extends('admin.common_admin')
@section('content')
<div class="mbnav">
    <span class="layui-breadcrumb"><a href="{{ url('admin') }}">首页</a> <a><cite>新建系统通知</cite></a></span>
</div>

@include('layout.message')

<form class="layui-form" method="post" action="">
    {{ csrf_field() }}

    <div class="layui-form-item" id="msg_title">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-inline">
            <input type="text" name="msg_title"  autocomplete="off"  class="layui-input" value="" />
        </div>
        <div class="layui-form-mid layui-word-aux">标题不能为空</div>
    </div>

    <div class="layui-form-item" id="send_to">
        <label class="layui-form-label">发送给</label>
        <div class="layui-input-inline">
            <textarea name="send_to" style="width: 500px;" placeholder="格式为 admin|admin1 系统默认留空为全站消息" class="layui-textarea"></textarea>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">消息内容</label>
        <div class="layui-input-block">
            <textarea name="msg_content" style="width: 500px; height: 200px;" placeholder="消息内容不能为空" class="layui-textarea"></textarea>
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="submit" class="layui-btn layui-btn-normal" lay-submit="" lay-filter="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

@stop

@section('script')
<script>
layui.use(['form'], function(){
    var form = layui.form();
});
</script>
@stop