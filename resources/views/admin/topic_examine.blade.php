@extends('admin.common_admin')
@section('content')
<div class="panel panel-default">
<div class="panel-heading">审核主题</div>
<div class="panel-body">
        {{ csrf_field() }}
        <h4><a href="{{url('topic/'.$topic['tid'])}}" target="_blank" title="{{ $topic['title'] }}">{{ $topic['title'] }}</a></h4>
        <div style="margin:20px 0">
            <small><a href="{{url('topic/'.$topic['catdir'])}}" target="_blank">{{ $topic['catname'] }}</a></small>
            <small>发布用户: {{ $topic['name'] }}</small>
            <small>发布时间: {{ $topic['created_at'] }}</small>
            <small>最后修改时间: {{ $topic['updated_at'] }}</small>
            <small>点击数: {{ $topic['click'] }}</small>
            <small></small>
        </div>
        <div>{!! $topic['content'] !!}</div>
    <div class="form">
        <form action="" method="post">

        </form>
    </div>
    <div class="">

    </div>
</div>
</div>
@stop
