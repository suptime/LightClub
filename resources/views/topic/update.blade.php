@extends('layout.base')
@section('left')
    <style>.forum-content-left{ float: none; width: 100%}</style>
    <div id="single" long="1"></div>
    @section('editor')
        <!--editor s-->
        <div class="editor-main">
            <div class="box-title">编辑主题</div>
            <div class="editor-content">
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
                        {{$errors->first('cid')}} {{$errors->first('title')}}
                    </div>
                    <div class="editor-pub-content">
                        {{$errors->first('content')}}
                        <textarea class="tinyce-editor" name="content" id="editor-content" style="display: none;">{{$topic->content}}</textarea>
                    </div>

                    <input type="hidden" id="tags" name="tags" value="" />
                    <button class="editor-pub-button" type="submit"><i class="k-i-edit"></i><span class="pub-text"> 立即修改 </span></button>
                </form>
            </div>
        </div>
        <!--editor e-->
    @stop
@stop

@section('right')
@stop