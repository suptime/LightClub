{{--已登录用户--}}
@if(Auth::check() && $isLoginStatus)
<div class="publisher">
    <div class="publisher-content">
        <div class="publisher-user-info"><img src="{{ Auth::user()->avstar ? Auth::user()->avstar : asset('assets/img/default.jpg') }}" />
            <div>{{Auth::user()->name}} <span class="user-rank-{{\App\User::getUserLevel(Auth::user()->grade)}} publisher-level"></span></div>
        </div>
        <div class="publisher-signature">
            {{ $user->signature ? $user->signature : '这家伙很懒,什么都没留下~' }}
        </div>
        <div class="publisher-score">
            <div class="score"><span>{{Auth::user()->score}}</span><span>积分</span></div>
            <div class="score"><span>{{Auth::user()->grade}}</span><span>经验值</span></div>
        </div>
        <div class="publisher-button">
            <a href="{{ url('space/'.Auth::id()) }}" class="go-page">我的主页</a>
            <a href="{{ url('user/letters') }}" class="send-message">我的私信</a>
            <a href="{{ url('user/collection') }}" class="send-message">我的收藏</a>
            <a href="{{ url('user/setting') }}" class="send-message">个人设置</a>
            <a href="{{ url('user/notice') }}" class="send-message">系统通知</a>
        </div>
    </div>
</div>
@else
{{--未登录显示--}}
<div class="publisher">
    <div class="publisher-content">
        <div class="publisher-user-info"><img src="{{ $user->avstar ? $user->avstar : asset('assets/img/default.jpg') }}" />
            <div>{{$user->name}} <span class="user-rank-{{\App\User::getUserLevel($user->grade)}} publisher-level"></span></div>
        </div>
        <div class="publisher-signature">
            {{ $user->signature ? $user->signature : '这家伙很懒,什么都没留下~' }}
        </div>
        <div class="publisher-score">
            <div class="score"><span>{{$user->score}}</span><span>积分</span></div>
            <div class="score"><span>{{$user->grade}}</span><span>经验值</span></div>
        </div>
        <div class="publisher-button">
            <a href="{{ url('space/'.$user->uid) }}" class="go-page">他的主页</a>
            <a href="javascript:;" onclick="window.open('{{ url('user/letters?toid='.$user->uid) }}', '_self')" class="send-message">给他私信</a>
        </div>
    </div>
</div>
@endif