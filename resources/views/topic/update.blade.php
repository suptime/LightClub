@extends('layout.base')
@section('title') 编辑帖子 - {{ $configs['site_name'] }} @stop
@section('left')
    <style>.forum-content-left{ float: none; width: 100%}</style>
    <div id="single" long="1"></div>
    @section('editor')
        <!--editor s-->
        <div class="editor-main">
            <div class="box-title">编辑主题</div>
            <div class="editor-content">
                @if(count($errors))
                    @foreach($errors->all() as $error)
                        <div class="content message-tips">
                            <div class="Huialert Huialert-danger"><span class="icon-remove">×</span>{{ $error }}</div>
                        </div>
                    @endforeach
                @endif

                <form action="" method="post">
                    {{ csrf_field() }}
                    <div class="put-select">
                        <input type="hidden" id="cateogry" name="cid" value="{{$topic->cid}}" />
                        <div id="form-category">
                            <div id="cate-current">{{$topic->catname}}</div>
                            <div id="cate-ids" style="display: none">
                                @foreach($navs as $val)
                                    <a data-cid="{{$val['cid']}}">{{ $val['catname'] }}</a>
                                @endforeach
                            </div>
                        </div>
                        <input class="topic-title-input" type="text" name="title" placeholder="填写将要发布的主题标题" value="{{$topic->title}}" />
                    </div>
                    <div class="editor-pub-content">
                        <textarea class="tinyce-editor" name="content" id="editor-content" style="display: none;">{{$topic->content}}</textarea>
                    </div>
                    <div class="editor-tags">
                        <input type="text" name="tags" placeholder="标签: (非必填) 以英文空格隔开,最多3个,每个最多8个字" id="tags" value="{{$topic->tags}}">
                    </div>
                    {!! Geetest::render() !!}
                    <button class="editor-pub-button" type="submit"><i class="k-i-edit"></i><span class="pub-text"> 立即修改 </span></button>
                </form>
            </div>
        </div>
        <!--editor e-->
    @stop
@stop

@section('right')
@stop