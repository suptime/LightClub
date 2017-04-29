{{--用户登录状态--}}
@if(Auth::check())
    <div class="publisher">
        <div class="publisher-content">
            <div class="publisher-user-info"><img src="{{ Auth::user()->avstar ? Auth::user()->avstar : asset('assets/img/default.jpg') }}" />
                <div>{{Auth::user()->name}} <span class="user-rank-{{\App\User::getUserLevel(Auth::user()->grade)}} publisher-level"></span></div>
            </div>
            <div class="publisher-signature">
            </div>
            <div class="publisher-score">
                <div class="score"><span>{{Auth::user()->score}}</span><span>积分</span></div>
                <div class="score"><span>{{Auth::user()->grade}}</span><span>经验值</span></div>
            </div>
            <div class="publisher-button">
                <a href="{{ url('space/'.Auth::id()) }}" class="go-page">他的主页</a>
                <a href="javascript:void(0)" class="send-message">发消息</a>
            </div>
        </div>
    </div>
@endif