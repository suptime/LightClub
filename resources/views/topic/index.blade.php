@extends('layout.base')

@section('title') {{ $title }} @stop
@section('keywords') {{ $keywords }} @stop
@section('description') {{ $description }} @stop

@section('left')
    <div class="topic-content">
        <div class="topic-type">
            <div class="type-content">
                <a href="" class="type-cur">最新发布</a>
                <a href="?type=replay">最后回复</a>
                <a href="?type=hot">最热话题</a>
            </div>
            <a href="{{url('topic/add')}}" class="pub-button">
                <i class="k-i-edit"></i><span class="pub-text">发布话题</span>
            </a>
        </div>

<!--topic-list s-->
<div class="topic-list">
@forelse($topics as $row)
    <!--topic-item s-->
        <div class="topic-item">
   <div class="user-avatar"><a href="{{ url('space/'.$row['uid']) }}" target="_blank"><img src="{{ $row['avstar'] ? $row['avstar'] : asset('assets/img/default.jpg') }}" /></a></div>
            <!--topic-content-item s-->
            <div class="brief-content">
                <div class="topic-top">
                    <div class="topic-title"><a href="{{url('topic/'.$row['tid'])}}">{{$row['title']}}</a></div>
                    <div class="icon-length">
                        @unless(!$row['istop'])<i class="k-i-top topic-stick topic-quality"></i>@endunless
                        @unless(!$row['isgood'])<i class="k-i-sel topic-star topic-quality"></i>@endunless
                        @unless(!$row['ispic'])<i class="kz-e-img-post topic-pic topic-quality"></i>@endunless
                    </div>
                </div>

                <div class="topic-info">
                    <span class="topic-person">{{ $row['name'] }}</span>
                    <span class="topic-time">{{ date('m月d日', strtotime($row['created_at'])) }}</span>
                    <div class="topic-tags"><a href="">#二手交易</a></div>
                    <div class="topic-operation">
                        <div class="watch"><i class="kz-e-scan"></i><span>{{$row['click']}}</span></div>
                        <div class="reply"><i class="kz-e-comment"></i><span>{{ $row['reply_total'] }}</span></div>
                    </div>
                </div>
            </div>
            <!--topic-content-item e-->
        </div>
        <!--topic-item s-->
    @empty
    <div style="height: 530px;position: relative">
        <div style="position: absolute;top: 50%;left: 50%;-webkit-transform: translate(-50%,-50%);transform: translate(-50%,-50%);text-align: center">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHwAAABuBAMAAAAXLmodAAAAJFBMVEVMaXHg4ODe3t7c3Nzk5OTb29vd3d38/Pz////m5ub09PTt7e2fp28oAAAAB3RSTlMA/rD1IFR//aPOrQAAAZlJREFUWMPt2DFPwkAUB/ALIe4QI3lMGDZdDGhca/gCJn4Bv0LD0AIfoLWd3iI8OukCdXShxC/ngJBcr0rvvUFN7r+R9EffvbvrJafUkYzulSQPvV/gjV6JN6z+pjEo8b4Vbw4fNX4y9OzGfKPx/c+62b9uN3GHYmpHG+yhFRXD7Lf0tM1W/9D30SbQ41sttMuSDqZXNvy2zINnG94xuO+JuFX1JreqvoKPPRG3qb6CB2cyblF9FZ+1jmfgfcvrZHYt4sG7jI9l3P8DvPvGzMt/581zYqftqbtVzM70VF3EgryqjoT7aiHhT4477rjjjptJChHPs1DAI4K5gKcEsObzLSLO2TxBJMHbJwSQ8cdOAMhvXUoAwJ+4HBGXR5fNh5ld4wgICjafICLFbE4A2pqz4ykB0pq943JE6rI3bESAWLC52TgrvjUaZ8MT0neLJc8BMGN/6yJCo3G15v3rQQCkkM1TAljGXB7FOeKazZNNRBn/mEgonC0kfBmHAo5UCM64KFu5891xxx13nMmF9zbCWyPhnZXsxuwTQLXqi98XjQUAAAAASUVORK5CYII=" />
        <p style="font-size: 12px; padding-top: 10px;color: #999">该分类下还没有任何话题哦~</p>
        </div>
    </div>
    @endforelse
</div>
<!--topic-list-item s-->

        <!--page s-->
        {!! $topics->appends($type_arg)->render() !!}
        <!--page e-->
    </div>
    <!--topic-list e-->

@stop
@section('right')
    {{--侧栏信息--}}
    @include('topic.side')
@stop