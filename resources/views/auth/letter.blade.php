@extends('layout.base')
@section('title'){{$user->name}}的个人主页@stop
@section('keywords') 个人主页 @stop
@section('description') 个人主页 @stop
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugs/layui/css/imui.css') }}">
@stop
@section('left')
    <div id="layui-layim-chat" class="layui-layer-content" style="height: 482px;border: 1px solid #e3e3e3">
        <ul class="layui-unselect layim-chat-list" style="height: 100%; display: block;">
            @if($sendTo)
                <li class="letter-send-user layim-this" data-uid="{{ $sendTo->uid }}"><img
                            src="{{ $sendTo->avstar ? $sendTo->avstar : asset('assets/img/default.jpg')  }}"><span>{{ $sendTo->name }}</span>
                    <i class="layui-icon remove-send-user" data-uid="{{ $sendTo->uid }}">&#x1007;</i>
                </li>
            @endif
            @foreach($sendUsers as $sendUser)
                <li class="letter-send-user" data-uid="{{ $sendUser->uid }}"><img
                            src="{{ $sendUser->avstar ? $sendUser->avstar : asset('assets/img/default.jpg')  }}"><span>{{ $sendUser->name }}</span>
                    <i class="layui-icon remove-send-user" data-uid="{{ $sendUser->uid }}">&#x1007;</i>
                </li>
            @endforeach
        </ul>
        <div class="layim-chat-box" style="margin-left: 200px;">
            <div class="layim-chat layim-chat-kefu layui-show">
                <div class="layim-chat-main" style="height: 340px;">
                    <div class="flush-letters" title="点击刷新消息列表"><i class="layui-icon">&#x1002;</i> 刷新消息</div>
                    <ul id="letter-content">
                        @if(!$sendTo)
                            @if( count($sendUsers))
                                <li class="layim-chat-mine">
                                    <div class="layim-chat-user"><img src="/assets/img/default.jpg"><cite>社区管理员</cite>
                                    </div>
                                    <div class="layim-chat-text">欢迎您回来,亲爱的会员 {{ $user->name }}, 你可以点击右边给用户发消息</div>
                                </li>
                            @else
                                <li class="layim-chat-mine">
                                    <div class="layim-chat-user"><img src="/assets/img/default.jpg"><cite>社区管理员</cite>
                                    </div>
                                    <div class="layim-chat-text">当前没有会话,试试给其他人发消息吧</div>
                                </li>
                            @endif
                        @endif
                        <a id="msg_bottom"></a>
                    </ul>
                </div>
                <div class="layim-chat-footer">
                    <div class="layim-chat-textarea"><textarea name="letter" placeholder="在此处输入回复消息"></textarea></div>
                    <div class="layim-chat-bottom">
                        <div class="layim-chat-send">
                            <span class="layui-btn layui-btn-normal">发送消息</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        layui.use(['element', 'layer'], function () {
            var element = layui.element();
            var layer = layui.layer;

            //监听折叠
            element.on('collapse(test)', function (data) {
                layer.msg('展开状态：' + data.show);
            });

            $('.is-read').on('click', function () {
                var btn = $(this);
                $.post('{{ url('user/notice') }}', {mid: $(this).attr('data-mid')}, function (data) {
                    if (data.status) {
                        btn.remove();
                    }
                    layer.msg(data.msg);
                }, 'json');
            });

            //定义全局变量
            var send_uid = null;
            var avatar = null;
            var username = null;
            @if($sendTo)
                send_uid = '{{ $sendTo->uid }}';
            @endif
            //获取对应用户发送的消息
            $('.letter-send-user').on('click', function () {
                $('.letter-send-user').removeClass('layim-this');
                $(this).addClass('layim-this');
                avatar = $(this).find('img').prop('src');
                username = $(this).find('span').text();
                send_uid = $(this).attr('data-uid');

                //将得到的消息输出到页面
                $.post('{{ url('user/letters/messages') }}', {send_uid: send_uid}, function (data) {
                    if (data.status) {
                        var html = '';
                        $.each(data.letters, function (i, v) {
                            if (v.send_uid == '{{$user->uid}}') {
                                html += '<li class="layim-chat-mine"><div class="layim-chat-user"><img src="{{$user->avstar}}"><cite><i>' + v.created_at + '</i>{{$user->name}}</cite></div><div class="layim-chat-text">' + v.letter + '</div></li>';
                            } else {
                                html += '<li><div class="layim-chat-user"><img src="' + avatar + '"><cite>' + username + '<i>' + v.created_at + '</i></cite></div><div class="layim-chat-text">' + v.letter + '</div></li>';
                            }
                        });
                        $('#letter-content').html(html);
                    }
                    /* else {
                     layer.msg(data.msg);
                     }*/
                }, 'json');
            });

            //发送新消息给指定用户
            $('.layim-chat-send').on('click', function () {
                var letter = $('textarea[name=letter]').val();
                var receive_uid = send_uid;

                //验证发送对象与消息是否为空
                if (receive_uid == null) {
                    layer.msg('请先选择消息发送对象');
                    return false;
                }
                if (letter == '') {
                    layer.msg('请先输入消息后再发送');
                    return false;
                }

                //发送ajax请求获取数据
                $.post('{{ url('user/letters/send') }}', {receive_uid: receive_uid, letter: letter}, function (data) {
                    if (data.status) {
                        var html = '';
                        $.each(data.letters, function (i, v) {
                            if (v.send_uid == '{{$user->uid}}') {
                                html += '<li class="layim-chat-mine"><div class="layim-chat-user"><img src="{{$user->avstar}}"><cite><i>' + v.created_at + '</i>{{$user->name}}</cite></div><div class="layim-chat-text">' + v.letter + '</div></li>';
                            } else {
                                html += '<li><div class="layim-chat-user"><img src="' + avatar + '"><cite>' + username + '<i>' + v.created_at + '</i></cite></div><div class="layim-chat-text">' + v.letter + '</div></li>';
                            }
                        });
                        $('#letter-content').html(html);
                    } else {
                        layer.msg(data.msg);
                    }
                }, 'json');
                //将文本框数据清空
                $('textarea[name=letter]').val('');
            });

            //删除会话
            $('.remove-send-user').on('click', function (event) {
                event.stopPropagation();    //阻止事件冒泡
                var convObj = $(this).closest('.letter-send-user');
                var uid = $(this).attr('data-uid');
                $.post('{{ url('user/letters/remove') }}', {send_uid: uid}, function (data) {
                    //if (data.status) {
                    var html = '<li class="layim-chat-mine"><div class="layim-chat-user"><img src="/assets/img/default.jpg"><cite>社区管理员</cite></div><div class="layim-chat-text">当前没有会话,试试给其他人发消息吧</div></li>';
                    $('#letter-content').html(html);
                    //layer.msg(data.msg);
                    //}
                    convObj.remove();
                    send_uid = null;
                });
            });

            //每隔一定时间自动获取消息列表数据
            setInterval(flushLettersList, 100000);

            //手动刷新消息列表
            $('.flush-letters').on('click', function () {
                var valid = $('.letter-send-user.layim-this').attr('data-uid');
                if (valid){
                    flushLettersList();
                }else {
                    layer.msg('亲,您还没选中对话哦,请选中对话后再刷新消息');
                }
            });

            //操作函数方法
            function flushLettersList() {
                var send_uid = $('.letter-send-user.layim-this').attr('data-uid');
                var avatar = $('.letter-send-user.layim-this').find('img').prop('src');
                var username = $('.letter-send-user.layim-this').find('span').text();
                if (!send_uid){
                    return;
                }
                $.post('{{ url('user/letters/messages') }}', {send_uid: send_uid}, function (data) {
                    if (data.status) {
                        var html = '';
                        $.each(data.letters, function (i, v) {
                            if (v.send_uid == '{{$user->uid}}') {
                                html += '<li class="layim-chat-mine"><div class="layim-chat-user"><img src="{{$user->avstar}}"><cite><i>' + v.created_at + '</i>{{$user->name}}</cite></div><div class="layim-chat-text">' + v.letter + '</div></li>';
                            } else {
                                html += '<li><div class="layim-chat-user"><img src="' + avatar + '"><cite>' + username + '<i>' + v.created_at + '</i></cite></div><div class="layim-chat-text">' + v.letter + '</div></li>';
                            }
                        });
                        $('#letter-content').html(html);
                    }
                    /* else {
                     layer.msg(data.msg);
                     }*/
                }, 'json');
            }

        });
    </script>
@stop