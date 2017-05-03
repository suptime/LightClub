@extends('admin.common_admin')

@section('content')
@include('layout.message')
<div class="mbnav">
    <span class="layui-breadcrumb"><a href="{{ url('admin') }}">首页</a> <a><cite>分类列表</cite></a></span>
</div>

<div style="">
    <a href="{{url('admin/category/add')}}" class="layui-btn layui-btn-small layui-btn-normal">添加分类</a>
</div>
<div class="layui-form">
 <table class="layui-table">
            <tr style="background: #f5f5f5">
                <th width="3%"><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
                <th class="text-center">分类ID</th>
                <th class="text-center">分类名称</th>
                <th class="text-center">分类路径</th>
                <th class="text-center">是否显示</th>
                <th class="text-center">上级分类</th>
                <th class="text-center">是否顶级</th>
                <th class="text-center">操作</th>
            </tr>
            @foreach($categories as $cate)
                <tr>
                    <td class="layui-ali text-center"><input type="checkbox" name="tid" value="{{ $cate['cid'] }}" lay-skin="primary"></td>
                    <td class="text-center">{{ $cate['cid'] }}</td>
                    <td class="text-center">{{ $cate['catname'] }}</td>
                    <td class="text-center">{{ $cate['catdir'] }}</td>
                    <td class="text-center">{{ $cateModel->getStatus('status', $cate['status']) }}</td>
                    <td class="text-center">{{ $cate['parent_id'] ? $cate['parent_id'] : '无' }}</td>
                    <td class="text-center">{{ $cateModel->getStatus('channel', $cate['ischannel']) }}</td>
                    <td class="text-center">
                        <a href="{{ url('admin/category/update', ['cid' => $cate['cid']]) }}" class="layui-btn layui-btn-mini layui-btn-normal">编辑</a>
                        <a href="{{ url('admin/category/remove', ['cid' => $cate['cid']]) }}" class="layui-btn layui-btn-mini layui-btn-danger">删除</a>
                    </td>
                </tr>
            @endforeach
        </table>
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