@extends('admin.common_admin')

@section('content')
<div class="mbnav">
    <span class="layui-breadcrumb"><a href="{{ url('admin/index') }}">首页</a> <a><cite>回帖列表</cite></a></span>
</div>

@include('layout.message')

<div class="layui-form">
 <table class="layui-table">
            <tr style="background: #f5f5f5">
                <th width="3%"><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
                <th class="text-center">回帖ID</th>
                <th class="text-center">所属文章ID</th>
                <th class="text-center">回帖用户</th>
                <th class="text-center">内容预览</th>
                <th class="text-center">上级回复</th>
                <th class="text-center">被点赞</th>
                <th class="text-center">显示</th>
                <th class="text-center">发布时间</th>
                <th class="text-center" width="20%">操作</th>
            </tr>
            @foreach($comments as $row)
                <tr>
                    <td class="layui-ali text-center"><input type="checkbox" name="tid" value="{{ $row['id'] }}" lay-skin="primary"></td>
                    <td class="text-center">{{ $row['id'] }}</td>
                    <td class="text-center"><a href="{{ url('topic/'. $row['tid']) }}" title="点击查看此贴  " target="_blank">{{ $row['tid'] }}</a> </td>
                    <td class="text-center">{{ $row['name'] }}</td>
                    <td class="text-center"><a href="javascript:;" class="view-msg layui-btn layui-btn-mini layui-btn-normal"><i class="layui-icon">&#xe615;</i> 详细</a>
                        <div class="msg-content" style="display: none;">
                            <div style="padding: 20px; line-height:24px;">{!! $row['comment'] !!}</div>
                        </div>
                    </td>
                    <td class="text-center">{{$row['pid']}} </td>
                    <td class="text-center">{{ $row['upvote'] }}</td>
                    <td class="text-center">{!!  $row['is_show'] ? '<i class="layui-icon" style="color:#5FB878">&#xe618;</i>' : '<i class="layui-icon" style="color:#FF5722">&#x1006;</i>'  !!} </td>
                    <td class="text-center">{{ date('Y-m-d H:i:s', $row['created_at']) }}</td>
                    <td class="text-center">
                        <a href="{{ url('admin/comments/show', ['id' => $row['id']]) }}" class="layui-btn layui-btn-mini">{{ $row['is_show'] ? '屏蔽' : '显示' }}</a>
                        <a href="{{ url('admin/comments/remove', ['id' => $row['id']]) }}" onclick="return confirm('确定要删除此回帖吗?')" class="layui-btn layui-btn-mini layui-btn-danger">删除</a>
                    </td>
                </tr>
            @endforeach
        </table>

        {!! $comments->render() !!}
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
                    area: ['800px', '500px'], //宽高
                    title: '回帖内容',
                    content: $(this).closest('tr').find('.msg-content').html()
                });
            })

        });
    </script>
@stop