@extends('layout.base')
@section('title') {{ $topic['title'] }} - {{ $configs['site_name'] }} @stop
@section('keywords') {{ $topic['tags'] }} @stop
@section('description') {{str_limit(strip_tags($topic['content']), 200)}} @stop

@section('left')
<div class="topic-content">
        <div class="topic-type detail-nav">
            <a href="{{url('topic/add')}}" class="pub-button"><i class="k-i-edit"></i><span class="pub-text">发布话题</span></a>
            <div class="detail-menu"><span><a href="{{ url('/') }}">社区首页</a> &gt;</span> <span><a href="{{ url($topic['catdir']) }}">{{ $topic['catname'] }}</a></span></div>
        </div>
        <div class="topic-detail-main">
            <div class="topic-detail-title">
                @unless(!$topic['istop'])<i class="k-i-top topic-stick topic-quality"></i>@endunless
                @unless(!$topic['isgood'])<i class="k-i-sel topic-star topic-quality"></i>@endunless
                @unless(!$topic['ispic'])<i class="kz-e-img-post topic-pic topic-quality"></i>@endunless
                <strong>{{$topic['title']}}</strong>
            </div>
            <div class="topic-detail-info">
                <span>{{ $topic['name'] }} 发表于</span>
                <span>{{ date('Y年m月d日 H:i:s', strtotime($topic['created_at'])) }}</span>
                <span class="topic-tag">{!! $topic['tags'] !!}</span>
                <span>
                @if( $topic['uid'] == $currentUser['uid'] || $currentUser['isadmin'] )<a href="{{url('topic/update/'.$topic['tid'])}}" class="update-topic">编辑本帖</a>
                    @endif
                </span>
                <div class="topic-watch">
                    <i class="kz-e-scan"></i><span>{{ $topic['click'] }}</span>
                </div>
            </div>
            <div class="topic-body-brief">
                {!! $topic['content'] !!}
            </div>
            <div class="topic-detail-mark">
                <div class="topic-detail-all">
                    <a href="javascript:void(0)" class="report" style="display: none;">举报</a>
                    <a href="javascript:void(0)" data-sid="{{$topic['tid']}}" data-type="topic" class="commentListItem-upvote upvote"><i class="k-i-like{{$topic['upvote'] ? '-o' : ''}}"></i><span>{{$topic['upvote'] ? $topic['upvote'] : ''}}</span><cite> 赞</cite></a>
                    <a href="#comment" class="reply"><i class="k-i-com"></i><span>回复</span></a>
                    <a href="javascript:void(0)" id="change-favorite" class="favorite">
                        @if($fav)
                            <i class="kz-e-star" style="color: #ffdd65"></i><span>已收藏</span></a>
                        @else
                            <i class="kz-e-star-o"></i><span>收藏</span></a>
                        @endif

                        @if($currentUser['uid'] == $topic['uid'] || $currentUser['isadmin'])
                    <a href="{{url('topic/remove/'.$topic['tid'])}}" class="commentListItem-manage" title="删除此回帖" onclick="return confirm('确定要删除吗?')"><i class="kz-e-del-new"></i><span>删除本帖</span></a>
                        @endif
                </div>
            </div>

            <!--回复 s-->
            @forelse($commentsTop as $val)
                @if($val['pid'] == 0)
            <div class="commentListItem-topic-item">
                <a href="{{url('space/'.$val['uid'])}}" target="_blank" class="commentListItem-user-avatar">
                    <img src="{{ $val['avstar'] ? $val['avstar'] : asset('assets/img/default.jpg')}}" />
                </a>
                <div class="commentListItem-item-content comtop">
                    <div class="commentListItem-user-info">
                        <span class="username">{{$val['name']}}</span>
                        <span class="user-rank-{{$val['level']}} commentListItem-level"></span>
                        <span class="commentListItem-floor accusation">举报</span>
                    </div>
                    <div class="comment-bar">
                        <div class="commentListItem-comment-brief">{!! $val['comment'] !!}</div>
                        <div class="comment-bar">
                            <span class="commentListItem-time">{{ date('Y年m月d日 H:i:s', $val['created_at']) }}</span>
                            <div class="commentListItem-comment-operation">
                                <a class="commentListItem-upvote" data-sid="{{$val['id']}}" data-type="comment" title="点赞"><i class="k-i-like{{$val['upvote'] ? '-o' : ''}}"></i><span>{{$val['upvote'] ? $val['upvote'] : ''}}</span></a>
                                <a class="commentListItem-reply top-reply" data-uid="{{$val['uid']}}" data-tid="{{$val['tid']}}" isopen="off" title="回帖"><i class="k-i-com"></i></a>
                @if($currentUser['uid'] == $val['uid'] || $currentUser['uid'] == $topic['uid'] || $currentUser['isadmin'])
                <a href="{{url('comment/remove/'.$val['id'])}}" class="commentListItem-manage" title="删除此回帖" onclick="return confirm('确定要删除吗?')"><i class="kz-e-del-new"></i></a>
                @endif
                            </div>
                        </div>
                    </div>
<!--楼内回复 s-->
<div class="comment-floor-box">
    @forelse($commentsSon as $son)
    @if($val['id'] == $son['pid'])
    <style type="text/css">.comment-floor-box{margin-top:20px;}</style>
    <div class="commentListItem-topic-item infloor-back">
        <div class="commentListItem-item-content" style="margin-left: 0">
            <div class="commentListItem-user-info">
                <span class="bold-name">{{$son['name']}}</span>
                <span class="user-rank-{{$son['level']}} commentListItem-level"></span>
            </div>
            <div class="comment-bar">
                <div class="commentListItem-comment-brief">{!! $son['comment'] !!}</div>
                <div class="comment-bar replay-line">
                    <span class="commentListItem-time">{{ date('Y年m月d日 H:i:s', $son['created_at']) }}</span>
                    <div class="commentListItem-comment-operation">
                        <a class="commentListItem-upvote" data-sid="{{$son['id']}}" data-type="comment" title="点赞"><i class="k-i-like{{$son['upvote'] ? '-o' : ''}}"></i><span>{{$son['upvote'] ? $son['upvote'] : ''}}</span></a>
                        <a class="commentListItem-reply son-reply" data-uid="{{$son['uid']}}"  data-tid="{{$son['tid']}}" data-username="{{$son['name']}}" isopen="off" title="回帖"><i class="k-i-com"></i></a>
                            @if($currentUser['uid'] == $son['uid'] || $currentUser['uid'] == $topic['uid'] || $currentUser['isadmin'])
                            <a href="{{url('comment/remove/'.$son['id'])}}" class="commentListItem-manage" title="删除此回帖" onclick="return confirm('确定要删除吗?')"><i class="kz-e-del-new"></i></a>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @empty
    @endforelse
</div>
<!--楼内回复 s-->
<div class="reply-editor" data-comid="{{$val['id']}}"></div>
                </div>
            </div>
                @endif
            @empty
                <div class="commentListItem-topic-item">
                    <p style="text-align: center;font-size: 15px; color: #3a9bf5">此话题还没有回帖哦,赶紧来占领沙发吧!</p>
                </div>
            @endforelse
            <!--回复 e-->

            {!! $commentsTop->render() !!}
        </div>
    </div>
@stop

@section('editor')
<!--editor s-->
<div class="editor-main">
    <div class="box-title">发表回复<a name="comment"></a></div>
    <div class="editor-content">
        @if(count($errors))
            @foreach($errors->all() as $error)
                <div class="content message-tips">
                    <div class="Huialert Huialert-danger"><span class="icon-remove">×</span>{{ $error }}</div>
                </div>
            @endforeach
        @endif
        <form action="{{url('comment/add')}}" method="post">
            {{ csrf_field() }}
            <div class="editor-pub-content">
                <input type="hidden" name="tid" value="{{$topic['tid']}}" />
                <textarea class="tinyce-editor" name="comment" id="editor-content"></textarea>
            </div>
            <div id="geetest_div">
                {!! Geetest::render() !!}
            </div>
            <button class="editor-pub-button" type="submit" id="send-editor-content"><i class="k-i-edit"></i><span class="pub-text">发表回复</span></button>
        </form>
    </div>
</div>
<!--editor e-->
@stop


@section('right')
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
    {{--侧栏信息--}}
    @include('topic.side')
@parent
@stop
<style>.reply-editor .geetest_holder.geetest_wind:nth-of-type(1){display: none;}</style>
@section('script')
<script>
$(function () {
    //点赞
    $('.commentListItem-upvote').on('click',function () {
        var This = $(this);
        var span = This.find('span');
        var num = span.text() || 0;
        var comid = This.attr('data-sid');
        var type = This.attr('data-type');
        @if($currentUser['uid'])
        $.post("{{url('comment/upvote')}}",{commentid:comid,type:type,num:num},function (data) {
            if (data.status == 1) {
                layer.msg(data.msg);
                span.text(data.num);
                This.find('i').attr('class','k-i-like-o');
            }else {
                layer.msg(data.msg);
            }
        },'json');
        @else
            layer.msg('请登录后点赞');
        @endif
    });

    //添加删除收藏
    $('#change-favorite').on('click', function () {
        var icon = $(this).find('i');
        var ispan = $(this).find('span');
        @if($currentUser['uid'])
        $.post("{{ url('collection/change') }}",{tid:"{{ $topic['tid'] }}"},function (data) {
            if (data.status){
                if (data.type == 'add') {
                    console.debug(icon,ispan);
                    icon.attr("class","kz-e-star");
                    icon.css('color','#ffdd65');
                    ispan.text('已收藏');
                }else {
                    icon.attr("class","kz-e-star-o");
                    icon.css('color','');
                    ispan.text('收藏');
                }
            }else {
                layer.msg(data.msg);
            }
        },'json');
        @else
            layer.msg('请登录后再收藏');
        @endif
    })
});
</script>
@stop