@extends('admin.common_admin')

@section('content')
<div class="mbnav">
    <span class="layui-breadcrumb"><a href="{{ url('admin') }}">首页</a> <a><cite>消息 / 通知 / 私信列表</cite></a></span>
</div>

@include('layout.message')

<div>
    <a href="{{url('admin/message/add')}}" class="layui-btn layui-btn-small layui-btn-normal">发送新消息</a>
</div>
<div class="layui-form">
 <table class="layui-table">
            <tr style="background: #f5f5f5">
                <th width="3%"><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
                <th class="text-center">发送者</th>
                <th class="text-center" width="23%">发给谁</th>
                <th class="text-center" width="35%">消息标题</th>
                <th class="text-center">全站</th>
                <th class="text-center">发送时间</th>
                <th class="text-center" width="12%">操作</th>
            </tr>
            @foreach($messages as $row)
                <tr>
                    <td class="layui-ali text-center"><input type="checkbox" name="tid" value="{{ $row['id'] }}" lay-skin="primary"></td>
                    <td class="text-center">{{ $row['name'] }}</td>
                    <td class="text-center" title="{{ $row['send_to'] }}">{{ $row['send_to'] ? str_limit($row['send_to'],30) : '所有人' }}</td>
                    <td><span class="msg-title">{{ $row['msg_title'] }}</span>
                        <div class="msg-content" style="display: none">
                            <p style="padding: 20px; line-height: 26px;">{{ $row['msg_content'] }}</p>
                        </div>
                    </td>
                    <td class="text-center">{!!  $row['isall'] ? '<i class="layui-icon" style="color:#5FB878">&#x1005;</i>' : '<i class="layui-icon" style="color:#FF5722">&#x1007;</i>' !!}</td>
                    <td class="text-center">{{ date('Y-m-d', $row['created_at']) }}</td>
                    <td class="text-center">
                        <a href="javascript:;" class="view-msg layui-btn layui-btn-mini layui-btn-normal"><i class="layui-icon">&#xe615;</i> 详细</a>
                        <a href="{{ url('admin/message/remove', ['id' => $row['id']]) }}" onclick="return confirm('确定要删除此消息吗?')" class="layui-btn layui-btn-mini layui-btn-danger">删除</a>
                    </td>
                </tr>
            @endforeach
        </table>

        {!! $messages->render() !!}
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
                    area: ['600px', '340px'], //宽高
                    title: '信息详情',
                    content: $(this).closest('tr').find('.msg-content').html()
                });
            })

        });
    </script>
@stop