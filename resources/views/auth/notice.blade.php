@extends('layout.base')
@section('title'){{$user->name}}的个人主页@stop
@section('keywords') 个人主页 @stop
@section('description') 个人主页 @stop

@section('left')
<div class="topic-content">
    <div class="userTopic-head">
        <a>系统消息列表</a>
    </div>

    <div class="layui-collapse" style=" border: none; font-size:14px;border-radius: 0" lay-accordion>
    @forelse($notices as $val)
        <div class="layui-colla-item">
            <h2 class="layui-colla-title" style="background: none"><span class="msg-time"><i class="layui-icon">&#xe60e;</i> {{ date('m月d日 H:i',$val['created_at']) }}</span>{{ $val['msg_title'] }}</h2>
            <div class="layui-colla-content">
                {{ $val['msg_content'] }}
            </div>
        </div>
    @empty
        <div style="height: 530px;position: relative">
            <div style="position: absolute;top: 50%;left: 50%;-webkit-transform: translate(-50%,-50%);transform: translate(-50%,-50%);text-align: center">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHwAAABuBAMAAAAXLmodAAAAJFBMVEVMaXHg4ODe3t7c3Nzk5OTb29vd3d38/Pz////m5ub09PTt7e2fp28oAAAAB3RSTlMA/rD1IFR//aPOrQAAAZlJREFUWMPt2DFPwkAUB/ALIe4QI3lMGDZdDGhca/gCJn4Bv0LD0AIfoLWd3iI8OukCdXShxC/ngJBcr0rvvUFN7r+R9EffvbvrJafUkYzulSQPvV/gjV6JN6z+pjEo8b4Vbw4fNX4y9OzGfKPx/c+62b9uN3GHYmpHG+yhFRXD7Lf0tM1W/9D30SbQ41sttMuSDqZXNvy2zINnG94xuO+JuFX1JreqvoKPPRG3qb6CB2cyblF9FZ+1jmfgfcvrZHYt4sG7jI9l3P8DvPvGzMt/581zYqftqbtVzM70VF3EgryqjoT7aiHhT4477rjjjptJChHPs1DAI4K5gKcEsObzLSLO2TxBJMHbJwSQ8cdOAMhvXUoAwJ+4HBGXR5fNh5ld4wgICjafICLFbE4A2pqz4ykB0pq943JE6rI3bESAWLC52TgrvjUaZ8MT0neLJc8BMGN/6yJCo3G15v3rQQCkkM1TAljGXB7FOeKazZNNRBn/mEgonC0kfBmHAo5UCM64KFu5891xxx13nMmF9zbCWyPhnZXsxuwTQLXqi98XjQUAAAAASUVORK5CYII=" />
                <p style="font-size: 12px; padding-top: 10px;color: #999">还没有消息发送过来~</p>
            </div>
        </div>
    @endforelse
    </div>
{!! $notices->render() !!}
</div>
@stop


@section('editor')
@stop


@section('right')
    {{--会员资料卡--}}
    @include('layout.user_info')
@stop

@section('script')
<script type="text/javascript">
layui.use(['element', 'layer'], function(){
    var element = layui.element();
    var layer = layui.layer;

    //监听折叠
    element.on('collapse(test)', function(data){
        layer.msg('展开状态：'+ data.show);
    });
});
</script>
@stop