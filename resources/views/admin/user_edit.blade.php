@extends('admin.common_admin')
@section('content')
    <div class="mbnav">
        <span class="layui-breadcrumb"><a href="{{ url('admin') }}">首页</a> <a><cite>修改用户资料</cite></a></span>
    </div>

    @include('layout.message')
<form class="layui-form" method="post" action="">
    {{ csrf_field() }}

    <div class="layui-form-item">
        <label class="layui-form-label">积分</label>
        <div class="layui-input-inline">
            <input type="text" name="score" lay-verify="required|number" autocomplete="off"  class="layui-input" value="{{ $user->score }}" />
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">经验</label>
        <div class="layui-input-inline">
            <input type="text" name="grade" lay-verify="required|number" autocomplete="off"  class="layui-input" value="{{ $user->grade }}" />
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">账号状态</label>
        <div class="layui-input-inline">
            <select name="status" id="status" lay-filter="">
                <option value="0">未激活</option>
                <option value="1">正常</option>
                <option value="-1">封禁</option>
            </select>
        </div>
    </div>

    <div class="layui-form-item" pane="">
        <label class="layui-form-label">是否管理员</label>
        <div class="layui-input-block">
            <input type="radio" name="isadmin" value="1" title="是" />
            <input type="radio" name="isadmin" value="0" title="否" />
        </div>
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
    $('#status option[value={{ $user->status }}]').prop('selected', true);
    $('input[name="isadmin"]').val([{{ $user->isadmin }}]);
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