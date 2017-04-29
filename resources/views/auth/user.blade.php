@extends('layout.base')
@section('title'){{Auth::user()->name}} 的个人主页@stop
@section('keywords') 个人主页 @stop
@section('description') 个人主页 @stop

@section('left')
<div class="topic-content">
    <div class="topic-content">
        <div class="userTopic-head">
            <a href="javascript:void(0)" class="topic-cur">话题</a>
            <a href="javascript:void(0)">回复</a>
            <a href="javascript:void(0)">通知</a>
            <a href="javascript:void(0)">私信</a>
        </div>

        <!--topic-list s-->
        <div class="topic-list userTopic-list">
            <!--topic-item s-->
            <div class="topic-item">
                <!--topic-content-item s-->
                <div class="brief-content">
                    <div class="topic-top">
                        <div class="topic-title"><a href="">服务希望能加入用户购买服务支付，还有付费发布的功能</a></div>
                        <div class="icon-length">
                            <i class="k-i-top topic-stick topic-quality"></i>
                            <i class="k-i-sel topic-star topic-quality"></i>
                            <i class="kz-e-img-post topic-pic topic-quality"></i>
                        </div>
                    </div>

                    <div class="topic-info"><span class="topic-person">牵手夕阳</span><span class="topic-time">5天前</span>
                        <div class="topic-tags"><a href="">#二手交易</a></div>
                        <div class="topic-operation">
                            <div class="watch"><i class="kz-e-scan"></i><span>75</span></div>
                            <div class="reply"><i class="kz-e-comment"></i><span>1</span></div>
                        </div>
                    </div>
                </div>
                <!--topic-content-item e-->
            </div>
            <!--topic-itemxxxxxxxxx s-->
        </div>
        <!--topic-list-item s-->

        <!--page s-->
        <div class="pagination">
            <a class="first" href="">上一页</a><a href="" class="cur-page">1</a><a href="">2</a><a href="">3</a><a href="">4</a><a href="">5</a><a class="last" href="">下一页</a>
        </div>
        <!--page e-->
    </div>
</div>
@stop


@section('editor')
    <!--editor s-->
    <div class="editor-main">
        <div class="box-title">发表回复</div>
        <div class="editor-content">
            <form action="" method="post">
                <div class="editor-pub-content">
                    <textarea class="tinyce-editor" name="content" id="editor-content"></textarea>
                </div>
                <button class="editor-pub-button" type="submit" id="send-editor-content">
                    <i class="k-i-edit"></i><span class="pub-text">发表回复</span>
                </button>
            </form>
        </div>
    </div>
    <!--editor e-->
@stop


@section('right')

    @if(Auth::check())
        <div class="publisher">
            <div class="publisher-content">
                <div class="publisher-user-info"><img src="http://pic.kuaizhan.com/g2/M00/8A/EF/CgpQVFcYPi-ANWs3AAATr2jAfiA220.png/imageView/v1/thumbnail/128x128" />
                    <div>{{Auth::user()->name}} <span class="user-rank-5 publisher-level"></span></div>
                </div>
                <div class="publisher-signature">
                    <span>男</span>
                    <span>15岁</span>
                    <span>摩羯座</span>
                </div>
                <div class="publisher-score">
                    <div class="score"><span>{{Auth::user()->score}}</span><span>积分</span></div>
                    <div class="score"><span>{{Auth::user()->grade}}</span><span>经验值</span></div>
                </div>
                <div class="publisher-button">
                    <a href="{{ url('user/home/'.Auth::id()) }}" class="go-page">他的主页</a>
                    <a href="javascript:void(0)" class="send-message">发消息</a>
                </div>
            </div>
        </div>
    @endif
@stop