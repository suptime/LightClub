@extends('admin.common_admin')
@section('content')
    <div class="mbnav">
        <span class="layui-breadcrumb"><a href="{{ url('admin/index') }}">首页</a> <a><cite>后台首页</cite></a></span>
    </div>

    @include('layout.message')

@stop

@section('script')
<script>

</script>
@stop