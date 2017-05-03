@extends('admin.common_admin')

@section('content')
<div class="mbnav">
    <span class="layui-breadcrumb"><a href="{{ url('admin') }}">首页</a> <a><cite>收藏列表</cite></a></span>
</div>

@include('layout.message')

<div class="layui-form">
 <table class="layui-table">
            <tr style="background: #f5f5f5">
                <th width="3%"><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
                <th class="text-center">ID</th>
                <th class="text-center">收藏帖子标题</th>
                <th class="text-center">所属用户</th>
                <th class="text-center">收藏时间</th>
                <th class="text-center" width="20%">操作</th>
            </tr>
            @foreach($collections as $row)
                <tr>
                    <td class="layui-ali text-center"><input type="checkbox" name="tid" value="{{ $row['id'] }}" lay-skin="primary"></td>
                    <td class="text-center">{{ $row['id'] }}</td>
                    <td><a href="{{ url('topic/'. $row['tid']) }}" title="点击查看此贴  " target="_blank">{{ $row['title'] }}</a> </td>
                    <td class="text-center"><a href="{{ url('space/'.$row['uid']) }}" target="_blank">{{ $row['name'] }}</a> </td>
                    <td class="text-center">{{ date('Y-m-d H:i:s', $row['created_at']) }}</td>
                    <td class="text-center">
                        <a href="{{ url('topic',['tid' => $row['tid']]) }}" target="_blank" class="layui-btn layui-btn-mini layui-btn-normal"><i class="layui-icon">&#xe615;</i> 查看帖子</a>
                        <a href="{{ url('admin/collections/remove', ['id' => $row['id']]) }}" onclick="return confirm('确定要删除此回帖吗?')" class="layui-btn layui-btn-mini layui-btn-danger">删除</a>
                    </td>
                </tr>
            @endforeach
        </table>

        {!! $collections->render() !!}
</div>
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


            $('.view-msg').on('click',function () {
                layer.open({
                    type: 1,
                    skin: 'layui-layer-rim', //加上边框
                    area: ['800px', '500px'], //宽高
                    title: '回帖内容',
                    content: $(this).closest('tr').find('.msg-content').html()
                });
            })

        });
    </script>
@stop