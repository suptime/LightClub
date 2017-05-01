@extends('admin.common_admin')

@section('content')
@include('layout.message')
    <!-- 失败提示框
    <!-- 自定义内容区域 -->
<div style="">
    <a href="{{url('admin/message/add')}}" class="layui-btn layui-btn-small layui-btn-normal">发送新消息</a>
</div>
<div class="layui-form">
 <table class="layui-table">
            <tr style="background: #f5f5f5">
                <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
                <th class="text-center">发送者</th>
                <th class="text-center">发给谁</th>
                <th class="text-center">消息类型</th>
                <th class="text-center">消息标题</th>
                <th class="text-center" width="40%">消息内容</th>
                <th class="text-center">全站</th>
                <th class="text-center">发送时间</th>
                <th class="text-center">操作</th>
            </tr>
            @foreach($messages as $row)
                <tr>
                    <td class="layui-ali text-center"><input type="checkbox" name="tid" value="{{ $row['id'] }}" lay-skin="primary"></td>
                    <td class="text-center">{{ $row['name'] }}</td>
                    <td class="text-center">{{ $row['send_to'] ? $row['send_to'] : '所有人' }}</td>
                    <td class="text-center">
                        @if($row['msg_type'] == 1)
                            私信
                        @elseif($row['msg_type'] == 2)
                            通知
                        @elseif($row['msg_type'] == 3)
                            公告
                        @endif
                    </td>
                    <td>{{ $row['msg_title'] }}</td>
                    <td>{{ $row['msg_content'] }}</td>
                    <td class="text-center">{!!  $row['isall'] ? '<i class="layui-icon" style="color:#5FB878">&#x1005;</i>' : '<i class="layui-icon" style="color:#FF5722">&#x1007;</i>' !!}</td>
                    <td class="text-center">{{ date('Y-m-d', $row['created_at']) }}</td>
                    <td class="text-center">
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

        });
    </script>
@stop