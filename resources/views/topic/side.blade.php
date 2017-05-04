@if($configs['announcement'] != '')
<div class="side-container">
    <div class="box-title">社区公告</div>
    <div class="box-brief announcement">{!! $configs['announcement'] !!}</div>
</div>
@endif

<div class="side-container">
    <div class="box-title">热门话题</div>
    <div class="box-brief">
        <ul class="hotopic">
            @foreach($hotTopics as $hot)
                <li><a href="{{ url('topic/'.$hot['tid']) }}" title="{{ $hot['title'] }}" target="_blank">{{ str_limit($hot['title'],60) }}</a></li>
            @endforeach
        </ul>
    </div>
</div>

<div class="side-container">
    <div class="box-title">微信关注</div>
    <div class="box-brief code-content">
        <img src="{{ asset('assets/img/wechat.jpg') }}">
        <span>关注收取回复提醒</span>
    </div>
</div>