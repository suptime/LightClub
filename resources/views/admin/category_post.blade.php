@extends('admin.common_admin')
@section('content')
    <div>
        <span class="layui-breadcrumb">
          <a href="/">首页</a>
          <a><cite>新增分类</cite></a>
        </span>
    </div>

    @include('layout.message')
<form class="layui-form" method="post" action="">
    {{ csrf_field() }}

    <div class="layui-form-item">
        <label class="layui-form-label">上级分类</label>
        <div class="layui-input-inline">
            <select name="parent_id" lay-filter="category">
                <option value="0">顶级分类</option>
                @foreach($cates as $k => $v)
                    <option value="{{ $k }}"
                            {{ isset($category['parent_id']) && $category['parent_id']==$k ? 'selected' : ''}}
                    >{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="layui-form-mid layui-word-aux">{{ $errors->first('parent_id') }}</div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">分类名称</label>
        <div class="layui-input-inline">
            <input type="text" name="catname" lay-verify="title" autocomplete="off"  class="layui-input" id="catname" value="{{ isset($category['catname']) ? $category['catname'] : ''}}" />
        </div>
        <div class="layui-form-mid layui-word-aux">{{ $errors->first('catname') }}</div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">分类路径</label>
        <div class="layui-input-inline">
            <input type="text" name="catdir" class="layui-input" id="catdir" autocomplete="off" value="{{ isset($category['catdir']) ? $category['catdir'] : ''}}" />
        </div>
        <div class="layui-form-mid layui-word-aux">{{ $errors->first('catdir') }}</div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">关键词</label>
        <div class="layui-input-inline">
            <input type="text" name="keywords" class="layui-input" autocomplete="off" id="keywords" value="{{ isset($category['keywords']) ? $category['keywords'] : ''}}"  />
        </div>
        <div class="layui-form-mid layui-word-aux">关键词以英文,隔开 不设置请留空</div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">分类描述</label>
        <div class="layui-input-block">
            <textarea name="description" class="layui-textarea" id="description">{{ isset($category['description']) ? $category['description'] : ''}}</textarea>
        </div>
    </div>

    <div class="layui-form-item" pane="">
        <label class="layui-form-label">显示状态</label>
        <div class="layui-input-block">
            @foreach( $cateModel->getStatus('status') as $key => $val)
            <input type="radio" name="status" value="{{ $key }}"  title="{{ $val }}"
                    {{ isset($category['status']) && $category['status'] == $key ? 'checked' : '' }}
            />
            @endforeach
        </div>
    </div>

    <div class="layui-form-item" pane="">
        <label class="layui-form-label">分类属性</label>
        <div class="layui-input-block">
            @foreach( $cateModel->getStatus('channel') as $key => $val)
        <input type="radio" name="ischannel" value="{{ $key }}" title="{{ $val }}"
                {{ isset($category['ischannel']) && $category['ischannel'] == $key ? 'checked' : '' }} />
            @endforeach
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

@stop

@section('script')
<script>
    @if(!isset($category))
    $('input[name="status"]').val([1]);
    $('input[name="ischannel"]').val([0]);
    @endif
    layui.use(['form'], function(){
        var form = layui.form()
            ,layer = layui.layer;
        //自定义验证规则
        form.verify({
            title: function(value){
                if(value.length < 5){
                    return '标题至少得5个字符啊';
                }
            }
        });
    });
</script>
@stop