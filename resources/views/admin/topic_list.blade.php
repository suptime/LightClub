@extends('admin.common_admin')
@section('content')
    <div class="mbnav">
        <span class="layui-breadcrumb"><a href="{{ url('admin') }}">首页</a> <a><cite>帖子列表</cite></a></span>
    </div>

    @include('layout.message')

<div class="layui-form">
    <table class="layui-table">
        <thead>
        <tr>
            <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
            <th width="5%">TID</th>
            <th>标题</th>
            <th width="8%">分类</th>
            <th>作者</th>
            <th width="5%">显示</th>
            <th>浏览</th>
            <th width="10%">发布时间</th>
            <th width="22%">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($topics as $row)
            <tr valign="middle">
                <td class="layui-ali text-center"><input type="checkbox" name="tid" value="{{ $row['tid'] }}" lay-skin="primary"></td>
                <td class="text-center">{{ $row['tid'] }}</td>
                <td class="text-left" width="30%">
                    @unless(!$row['ispic'])<span style="color: #f60">图</span>@endunless
                    <a href="{{url('topic/'.$row['tid'])}}" target="_blank">{{ $row['title'] }}</a>
                </td>
                <td class="text-center">{{ $row['catname'] }}</td>
                <td class="text-center">{{ $row['name'] }}</td>
                <td class="text-center">@if($row['islook']) 正常 @else 封禁 @endif</td>
                <td class="text-center">{{ $row['click'] }}</td>
                <td class="text-center">{{ date('Y-m-d',strtotime($row['created_at'])) }}</td>
                <td class="text-center" valign="middle">
                    <a href="{{ url('admin/topic/examine', ['tid' => $row['tid'],'operate'=>'isshow']) }}" class="layui-btn layui-btn-mini layui-btn-primary">{{ $row['isshow'] ? '取消审核' : '审核' }}</a>
                    <a href="{{ url('admin/topic/examine', ['tid' => $row['tid'],'operate'=>'islook']) }}" class="layui-btn layui-btn-mini layui-btn-normal">{{ $row['islook'] ? '封禁' : '解封' }}</a>
                    <a href="{{ url('admin/topic/examine', ['tid' => $row['tid'],'operate'=>'isgood']) }}" class="layui-btn layui-btn-mini layui-btn-warm">{{ $row['isgood'] ? '不加精' : '加精' }}</a>
                    <a href="{{ url('admin/topic/examine', ['tid' => $row['tid'],'operate'=>'istop']) }}" class="layui-btn layui-btn-mini layui-btn-normal">{{ $row['istop'] ? '不置顶' : '置顶' }}</a>
                    <a href="{{ url('admin/topic/remove', ['tid' => $row['tid']]) }}" class="layui-btn layui-btn-mini layui-btn-danger">删除</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <style>.layui-btn+.layui-btn{ margin: 0;}</style>
</div>

<!-- 分页  -->
{!! $topics->render() !!}
@stop

@section('script')
<script type="text/javascript">
layui.use('form', function(){
    var $ = layui.jquery, form = layui.form();

    //全选
    form.on('checkbox(allChoose)', function(data){
        var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]');
        child.each(function(index, item){
            item.checked = data.elem.checked;
        });
        form.render('checkbox');
    });

});
</script>
@stop