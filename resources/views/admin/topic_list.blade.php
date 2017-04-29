@extends('admin.common_admin')
@section('content')
@include('layout.message')
    <!-- 自定义内容区域 -->
    <div class="panel panel-default">
        <table class="table table-hover table-responsive table-bordered" style="font-size: 13px;">
            <tr style="background: #f5f5f5">
                <th class="text-center" width="5%">TID</th>
                <th class="text-center">标题</th>
                <th class="text-center" width="8%">分类</th>
                <th class="text-center">作者</th>
                <th class="text-center" width="5%">显示</th>
                <th class="text-center">浏览</th>
                <th class="text-center" width="10%">发布时间</th>
                <th class="text-center" width="22%">操作</th>
            </tr>
            @foreach($topics as $row)
                <tr valign="middle">
                    <td class="text-center">{{ $row['tid'] }}</td>
                    <td class="text-left" width="30%">
                        <a href="{{url('topic/'.$row['tid'])}}" target="_blank">{{ $row['title'] }}</a>
                        @unless(!$row['ispic'])<span class="label label-success label-xs">图</span>@endunless
                    </td>
                    <td class="text-center">{{ $row['catname'] }}</td>
                    <td class="text-center">{{ $row['name'] }}</td>
                    <td class="text-center">@if($row['islook']) 正常 @else 封禁 @endif</td>
                    <td class="text-center">{{ $row['click'] }}</td>
                    <td class="text-center">{{ date('Y-m-d',strtotime($row['created_at'])) }}</td>
                    <td class="text-center" valign="middle">
<a href="{{ url('admin/topic/examine', ['tid' => $row['tid'],'operate'=>'isshow']) }}" class="btn btn-success btn-xs">{{ $row['isshow'] ? '取消审核' : '审核' }}</a>
<a href="{{ url('admin/topic/examine', ['tid' => $row['tid'],'operate'=>'islook']) }}" class="btn btn-xs btn-info">{{ $row['islook'] ? '封禁' : '解封' }}</a>
<a href="{{ url('admin/topic/examine', ['tid' => $row['tid'],'operate'=>'isgood']) }}" class="btn btn-xs btn-warning">{{ $row['isgood'] ? '不加精' : '加精' }}</a>
<a href="{{ url('admin/topic/examine', ['tid' => $row['tid'],'operate'=>'istop']) }}" class="btn btn-xs btn-primary">{{ $row['istop'] ? '不置顶' : '置顶' }}</a>
<a href="{{ url('admin/topic/remove', ['tid' => $row['tid']]) }}" class="btn btn-xs btn-danger">删除</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <!-- 分页  -->
    {!! $topics->render() !!}
@stop