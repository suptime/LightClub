@extends('layout.base')
@section('title')个人资料设置 - {{ $configs['site_name'] }} @stop

@section('left')
<div class="topic-content">
    <div class="userTopic-head">
        <a>个人资料设置</a>
    </div>

    <!--topic-list s-->
    <div class="topic-list userTopic-list">
        <form class="layui-form user-update-setting" action="" method="post">
            {{ csrf_field() }}
            <div class="layui-form-item">
                <label class="layui-form-label">头像</label>
                <div class="layui-input-inline">
                    <img id="show-avstar" src="{{ $user->avstar ? $user->avstar : asset('assets/img/default.jpg') }}" width="120" height="120" />
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">上传头像</label>
                <div class="layui-input-inline">
                    <input type="file" name="userface" class="layui-upload-file">
                    <input type="hidden" name="avstar" id="avstar" value="" />
                </div>
                <div class="layui-form-mid layui-word-aux">头像最大300x300而且不超过500kb,比例为1:1</div>
            </div>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">手机号码</label>
                    <div class="layui-input-inline">
                        <input type="tel" name="mobile" lay-verify="phone" autocomplete="off" value="{{ $user->mobile }}" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">{{ $errors->first('mobile') ? $errors->first('mobile') :'请填写11手机号码' }}</div>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">QQ号码</label>
                    <div class="layui-input-inline">
                        <input type="tel" name="qqnum" lay-verify="qq|number" autocomplete="off" value="{{ $user->qqnum }}" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">{{ $errors->first('qqnum') ? $errors->first('qqnum') :'请填写您常用的QQ号码' }}</div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">旧密码</label>
                <div class="layui-input-inline">
                    <input type="password" name="oldpassword" lay-verify="required|oldpass" placeholder="请输入新密码" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux" style="color: #f60">{{ $errors->first('password') ? $errors->first('password') :'必填, 用于身份验证' }}</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">新密码</label>
                <div class="layui-input-inline">
                    <input type="password" name="password" lay-verify="pass" placeholder="请输入新密码" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">{{ $errors->first('password') ? $errors->first('password') :'请填写6到18位密码,不改请留空' }}</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">确认密码</label>
                <div class="layui-input-inline">
                    <input type="password" name="repassword" lay-verify="repass" placeholder="请再次输入密码" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">{{ $errors->first('repassword') ? $errors->first('repassword') :'请填写6到18位密码' }}</div>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">个性签名</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" name="signature" class="layui-textarea">{{ $user->signature }}</textarea>{{ $errors->first('signature') }}
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

@section('script')
    <script>
        layui.use(['form'], function(){
            var form = layui.form();
            form.verify({
                oldpass: [/^[\S]{6,18}$/,'密码必须6到18位，且不能出现空格'],
                qq: [/^[\S]{5,10}$/,'QQ号码只能是5-10位数字'],
                repass:function (value) {
                    var newPass = $('input[name=password]').val();
                    if (value != newPass) {
                        return '确认密码与新密码不一致';
                    }
                }
            });
        });
        layui.use('upload', function(){
            layui.upload({
                url: "{{ url('attachment/upload') }}",
                ext: 'jpg|png|gif',
                success: function(data){
                    $('#avstar').val(data.data.src);
                    $('#show-avstar').prop('src', data.data.src);
                }
            });
        });
    </script>
    @stop