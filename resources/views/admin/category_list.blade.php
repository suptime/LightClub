@extends('admin.common_admin')

@section('content')
@include('layout.message')
    <!-- 失败提示框
    <!-- 自定义内容区域 -->
<div style="padding-bottom: 15px"><a href="{{url('admin/category/add')}}" class="btn btn-primary btn-sm">添加分类</a> </div>
<div class="panel panel-default">
        <table class="table table-hover table-bordered">
            <tr style="background: #f5f5f5">
                <th class="text-center">分类名称</th>
                <th class="text-center">分类路径</th>
                <th class="text-center">是否显示</th>
                <th class="text-center">上级分类</th>
                <th class="text-center">是否顶级</th>
                <th class="text-center">操作</th>
            </tr>
            @foreach($categories as $cate)
                <tr>
                    <td class="text-center">{{ $cate['catname'] }}</td>
                    <td class="text-center">{{ $cate['catdir'] }}</td>
                    <td class="text-center">{{ $cateModel->getStatus('status', $cate['status']) }}</td>
                    <td class="text-center">{{ $cate['parent_id'] }}</td>
                    <td class="text-center">{{ $cateModel->getStatus('channel', $cate['ischannel']) }}</td>
                    <td class="text-center">
                        <a href="{{ url('admin/category/update', ['cid' => $cate['cid']]) }}" class="btn btn-success btn-sm">编辑</a>
                        <a href="{{ url('admin/category/remove', ['cid' => $cate['cid']]) }}" class="btn btn-danger btn-sm">删除</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <!-- 分页  -->
    {{--{{ $students->appends(Request::input())->render() }}--}}
@stop