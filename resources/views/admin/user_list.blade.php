@extends('admin.common_admin')

@section('content')
<div class="mbnav">
    <span class="layui-breadcrumb"><a href="{{ url('admin') }}">首页</a> <a><cite>注册用户列表</cite></a></span>
</div>

@include('layout.message')

<div class="layui-form">
 <table class="layui-table">
            <tr style="background: #f5f5f5">
                <th width="3%"><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
                <th class="text-center">用户ID</th>
                <th class="text-center">用户名</th>
                <th class="text-center">邮箱</th>
                <th class="text-center">手机</th>
                <th class="text-center">QQ</th>
                <th class="text-center">签名</th>
                <th class="text-center">积分</th>
                <th class="text-center">经验</th>
                <th class="text-center">等级</th>
                <th class="text-center">头像</th>
                <th class="text-center">管理员</th>
                <th class="text-center">状态</th>
                <th class="text-center">注册时间</th>
                <th class="text-center">操作</th>
            </tr>
            @foreach($users as $row)
                <tr>
                    <td class="layui-ali text-center"><input type="checkbox" name="tid" value="{{ $row['uid'] }}" lay-skin="primary"></td>
                    <td class="text-center">{{ $row['uid'] }}</td>
                    <td class="text-center">{{ $row['name'] }}</td>
                    <td class="text-center">{{ $row['email'] }}</td>
                    <td class="text-center">{{ $row['mobile'] }}</td>
                    <td class="text-center">{{ $row['qqnum'] }}</td>
                    <td class="text-center">
                        @if($row['signature'])
                        <a href="javascript:;" class="qianming" data-text="{{ $row['signature'] }}"><i class="layui-icon">&#xe615;</i></a> @else 无  @endif
                    </td>
                    <td class="text-center">{{ $row['score'] }}</td>
                    <td class="text-center">{{ $row['grade'] }}</td>
                    <td class="text-center">1</td>
                    <td class="text-center">
                        @if($row['avstar'])
                        <a href="javascript:;" class="view-avatar" data-img="{{ $row['avstar'] }}"><i class="layui-icon">&#xe64a;</i></a>
                            @else
                            无
                            @endif
                    </td>
                    <td class="text-center">{!! $row['isadmin'] ? '<i class="layui-icon" style="color:#1E9FFF">&#xe618;</i>' : '<i class="layui-icon" style="color:#1E9FFF">&#x1006;</i>' !!}</td>
                    <td class="text-center">
                            @if($row['status'] == 1)
                                <i class="layui-icon" style="color: #0a0">&#xe616;</i>
                            @elseif($row['status'] == -1)
                                <i class="layui-icon" style="color: #FF5722">&#x1007;</i>
                            @else
                                <i class="layui-icon" style="color: #F7B824">&#xe60f;</i>
                            @endif
                    </td>
                    <td class="text-center">{{ $row['created_at'] }}</td>
                    <td class="text-center">
                        <a href="{{ url('admin/users/edit', ['uid' => $row['uid']]) }}" class="edit-data layui-btn layui-btn-mini layui-btn-normal"><i class="layui-icon" title="编辑用户状态">&#xe642;</i></a>
                    </td>
                </tr>
            @endforeach
        </table>

        {!! $users->render() !!}
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

            $('.view-avatar').on('click', function () {
                layer.open({
                    type: 1,
                    area: ['200px', '200px'],
                    title: '',
                    content: '<img src="' + $(this).attr('data-img') + '" width="200" height="200" />',
                });
            });

            $('.qianming').on('click', function () {
                layer.open({
                    type: 1,
                    area: ['400px', '200px'],
                    title: '用户个性签名',
                    content: '<div style="padding: 20px; line-height: 26px;">'+$('.qianming').attr('data-text')+'</div>',
                });
            });

        });
    </script>
@stop