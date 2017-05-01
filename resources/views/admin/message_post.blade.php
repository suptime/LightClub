@extends('admin.common_admin')
@section('content')
<div class="mbnav">
    <span class="layui-breadcrumb"><a href="{{ url('admin') }}">首页</a> <a><cite>发送新消息</cite></a></span>
</div>

@include('layout.message')

<form class="layui-form" method="post" action="">
    {{ csrf_field() }}

    <div class="layui-form-item">
        <label class="layui-form-label">消息类型</label>
        <div class="layui-input-inline">
            <select name="msg_type" lay-filter="msg" id="msg-type">
                <option value="2">系统通知</option>
                <option value="3">网站公告</option>
            </select>
        </div>
    </div>

    <div class="layui-form-item" id="msg_title">
        <label class="layui-form-label">消息标题</label>
        <div class="layui-input-inline">
            <input type="text" name="msg_title" lay-verify="msg_title" autocomplete="off"  class="layui-input" value="" />
        </div>
        <div class="layui-form-mid layui-word-aux"></div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">消息内容</label>
        <div class="layui-input-block">
            <textarea name="msg_content" style="width: 500px; height: 200px;" class="layui-textarea"></textarea>
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