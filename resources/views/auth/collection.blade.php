@extends('layout.base')
@section('title'){{$user->name}}的个人主页@stop
@section('keywords') 个人主页 @stop
@section('description') 个人主页 @stop

@section('left')
<div class="topic-content">
    <div class="userTopic-head">
        <a href="{{url('space/'.$user->uid)}}">话题</a>
        <a href="{{url('reply/'.$user->uid)}}">回复</a>
        {!!  $current_uid ? '<a href="'.url('user/collection').'" class="topic-cur">收藏</a>' : ''  !!}
        {!!  $current_uid ? '<a href="'.url('user/messages').'">私信</a>' : ''  !!}
    </div>

    <!--topic-list s-->
    <div class="topic-list userTopic-list">
        <!--topic-item s-->
        @forelse($favrates as $val)
        <div class="topic-item">
            <div class="brief-content">
                <div class="topic-top">
                    <div class="topic-title"><a href="{{ url('topic/'.$val['tid']) }}" target="_blank">{{ $val['title'] }}</a></div>
                    <div class="icon-length">
                        @unless(!$val['istop'])<i class="k-i-top topic-stick topic-quality"></i>@endunless
                        @unless(!$val['isgood'])<i class="k-i-sel topic-star topic-quality"></i>@endunless
                        @unless(!$val['ispic'])<i class="kz-e-img-post topic-pic topic-quality"></i>@endunless
                    </div>
                </div>

                <div class="topic-info">
                    <span><a href="javascript:;" onclick="window.open('{{ url('user/collection/remove/'.$val['tid'].'&'.$val['id']) }}', '_self'); return confirm('确定要移除收藏夹吗?')" class="collection-remove">移除收藏夹</a></span>
                    <span class="topic-person">此贴于 {{ date('Y年m月d日', strtotime($val['created_at'])) }} 加入收藏</span>
                    <div class="topic-operation">
                        <div class="watch"><i class="kz-e-scan"></i><span>{{ $val['click'] }}</span></div>
                        <div class="reply"><i class="kz-e-comment"></i><span>{{ $val['reply_total'] }}</span></div>
                    </div>
                </div>
            </div>
        </div>
            @empty
            <div style="height: 530px;position: relative">
                <div style="position: absolute;top: 50%;left: 50%;-webkit-transform: translate(-50%,-50%);transform: translate(-50%,-50%);text-align: center">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHwAAABuBAMAAAAXLmodAAAAJFBMVEVMaXHg4ODe3t7c3Nzk5OTb29vd3d38/Pz////m5ub09PTt7e2fp28oAAAAB3RSTlMA/rD1IFR//aPOrQAAAZlJREFUWMPt2DFPwkAUB/ALIe4QI3lMGDZdDGhca/gCJn4Bv0LD0AIfoLWd3iI8OukCdXShxC/ngJBcr0rvvUFN7r+R9EffvbvrJafUkYzulSQPvV/gjV6JN6z+pjEo8b4Vbw4fNX4y9OzGfKPx/c+62b9uN3GHYmpHG+yhFRXD7Lf0tM1W/9D30SbQ41sttMuSDqZXNvy2zINnG94xuO+JuFX1JreqvoKPPRG3qb6CB2cyblF9FZ+1jmfgfcvrZHYt4sG7jI9l3P8DvPvGzMt/581zYqftqbtVzM70VF3EgryqjoT7aiHhT4477rjjjptJChHPs1DAI4K5gKcEsObzLSLO2TxBJMHbJwSQ8cdOAMhvXUoAwJ+4HBGXR5fNh5ld4wgICjafICLFbE4A2pqz4ykB0pq943JE6rI3bESAWLC52TgrvjUaZ8MT0neLJc8BMGN/6yJCo3G15v3rQQCkkM1TAljGXB7FOeKazZNNRBn/mEgonC0kfBmHAo5UCM64KFu5891xxx13nMmF9zbCWyPhnZXsxuwTQLXqi98XjQUAAAAASUVORK5CYII=" />
                    <p style="font-size: 12px; padding-top: 10px;color: #999">还没有收藏的帖子哦~~</p>
                </div>
            </div>
    @endforelse
        <!--topic-itemxxxxxxxxx s-->
    </div>
    <!--topic-list-item s-->

{!! $favrates->render() !!}
</div>
@stop


@section('editor')
@stop


@section('right')
    {{--会员资料卡--}}
    @include('layout.user_info')
@stop