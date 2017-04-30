@extends('layout.base')
@section('title'){{$user->name}}的个人主页@stop
@section('keywords') 个人主页 @stop
@section('description') 个人主页 @stop
@section('style')
<link rel="stylesheet" href="{{ asset('assets/plugs/layui/css/layui.css') }}" />
@stop

@section('left')
<div class="topic-content">
    <div class="userTopic-head">
        <a>个人资料设置</a>
    </div>

    <!--topic-list s-->
    <div class="topic-list userTopic-list">
        <form class="layui-form user-update-setting" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">头像</label>
                <div class="layui-input-inline">
                    <img id="show-avstar" src="{{ $user->avstar ? $user->avstar : asset('assets/img/default.jpg') }}" width="120" height="120" />
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">上传头像</label>
                <div class="layui-input-inline">
                    <input type="file" name="file" class="layui-upload-file">
                    <input type="hidden" name="avstar" id="avstar" value="" />
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">邮箱</label>
                <div class="layui-input-inline">
                    <input type="text" name="email" lay-verify="email" autocomplete="off" value="{{ $user->email }}" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">此邮箱用于找回密码与激活验证</div>
            </div>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">手机号码</label>
                    <div class="layui-input-inline">
                        <input type="tel" name="mobile" lay-verify="phone" autocomplete="off" value="{{ $user->mobile }}" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">请填写11手机号码</div>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">QQ号码</label>
                    <div class="layui-input-inline">
                        <input type="tel" name="qqnum" lay-verify="qq" autocomplete="off" value="{{ $user->qqnum }}" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">请填写您常用的QQ号码</div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">新密码</label>
                <div class="layui-input-inline">
                    <input type="password" name="password" lay-verify="pass" placeholder="请输入新密码" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">请填写6到12位密码,不改请留空</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">确认密码</label>
                <div class="layui-input-inline">
                    <input type="password" name="repassword" lay-verify="pass" placeholder="请再次输入密码" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">请填写6到12位密码</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">性别</label>
                <div class="layui-input-block">
                    <input type="radio" name="sex" value="男" title="男" checked="">
                    <input type="radio" name="sex" value="女" title="女">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">个性签名</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" name="signature" class="layui-textarea">{{ $user->signature }}</textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal" lay-submit="" lay-filter="demo1">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
    <!--topic-list-item s-->
</div>
@stop


@section('editor')
@stop


@section('right')
    {{--会员资料卡--}}
    @include('layout.user_info')
@stop
@section('footer')
<div class="footer content">
    <span>© 2017 豆萌社区</span>
    <a href="" target="_blank">注册协议</a> |
    <a href="" target="_blank">关于我们</a> |
    <a class="ueg_feedback-link" href="" target="_blank">意见反馈</a> |
    <a href="" target="_blank">网络谣言警示</a>
</div>
<script src="https://cdn.bootcss.com/jquery/1.11.1/jquery.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugs/layui/layui.js') }}"></script>
<script>
layui.use(['form'], function(){
    var form = layui.form();
    //自定义验证规则
    form.verify({
        title: function(value){
            if(value.length < 5){
                return '标题至少得5个字符啊';
            }
        }
        ,pass: [/(.+){6,12}$/, '密码必须6到12位']
    });
});
layui.use('upload', function(){
    layui.upload({
        url: "{{ url('topic/uploadfile') }}",
        ext: 'jpg|png|gif',
        success: function(data){
            $('#avstar').val(data.data.src);
            $('#show-avstar').prop('src', data.data.src);
        }
    });
});
</script>
@stop