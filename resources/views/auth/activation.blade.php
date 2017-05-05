@extends('layout.base')
@section('title')账号激活 - {{ $configs['site_name'] }} @stop

@section('left')
    <style>.forum-content-left{ width: 100%;float: none}</style>
<div class="topic-content">
    <div class="userTopic-head">
        <a>新用户账户激活</a>
    </div>
    @if($user['status'] == 0)
    <div class="active-main">
        <p>尊敬的用户: <span>{{ $user['name'] }}</span> ,感谢您注册本站会员, 您只差一步即可完成注册</p>
        <p>您当前账户尚未进行邮件激活, 将不能正常使用网站功能. 请点击下面的 "<span>立即发送激活邮件完成账户激活</span>".</p>
        <button class="active-mail layui-btn layui-btn-big layui-btn-normal">立即发送激活邮件</button>
        <p>60秒后可再次发送邮件</p>
        <p class="tips">温馨提示: 如果长时间没收到邮件,请重新点击发送. 点击发送邮件后, 请进入您填写邮箱地址的管理中心确认收到邮件并点击激活链接完成账号激活,感谢您的支持</p>
    </div>
    @endif

    @if($user['status'] == 1)
    <div class="active-main">
        <p>尊敬的用户: <span>{{ $user['name'] }}</span> ,恭喜您的账户激活成功</p>
        <button class="active-mail layui-btn layui-btn-big" style="background: #139e31!important;" onclick="window.open('{{ url('user/setting') }}', '_self')">已激活, 注册完成</button>
        <p>感谢您注册我站账号,您现在可以尽情浏览使用本站所提供的服务了!</p>
    </div>
    @endif
</div>
@stop
@section('editor') @stop
@section('right') @stop
@section('script')
    @if($user['status'] == 0)
<script>
$('.active-mail').click(function () {
    if ($(this).hasClass('layui-btn-disabled')){
        return;
    }
    $.getJSON('{{url('user/activation')}}',function (data) {
        if (data == 'success'){
            $('.active-mail').addClass('layui-btn-disabled');
            $('.active-mail').removeClass('layui-btn-normal');
            $('.active-mail').text('邮件已发送,请查收');
            layer.msg('激活邮件已发送成功');
        }else {
            layer.msg('激活邮件发送失败');
        }
    });

    setTimeout(function () {
        $('.active-mail').removeClass('layui-btn-disabled');
        $('.active-mail').addClass('layui-btn-normal');
        $('.active-mail').text('立即发送激活邮件');
    }, 10000)

});
</script>
    @endif
@stop