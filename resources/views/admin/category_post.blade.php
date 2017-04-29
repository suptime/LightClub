@extends('admin.common_admin')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">新增分类</div>
        <div class="panel-body">
            <form class="form-horizontal" method="post" action="">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">上级分类</label>
                    <div class="col-sm-5">
                        <select name="parent_id" class="form-control">
                            <option value="0">顶级分类</option>
                            @foreach($cates as $k => $v)
                                <option value="{{ $k }}"
                  {{ isset($category['parent_id']) && $category['parent_id']==$k ? 'selected' : ''}}
                                >{{ $v }}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{ $errors->first('parent_id') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">分类名称</label>
                    <div class="col-sm-5">
                        <input type="text" name="catname" class="form-control" id="catname" value="{{ isset($category['catname']) ? $category['catname'] : ''}}" />
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{ $errors->first('catname') }}</p>
                    </div>
                </div>


                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">分类路径</label>
                    <div class="col-sm-5">
                        <input type="text" name="catdir" class="form-control" id="catdir" value="{{ isset($category['catdir']) ? $category['catdir'] : ''}}" />
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{ $errors->first('catdir') }}</p>
                    </div>
                </div>


                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">关键词</label>
                    <div class="col-sm-5">
                        <input type="text" name="keywords" class="form-control" id="keywords" value="{{ isset($category['keywords']) ? $category['keywords'] : ''}}"  />
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">关键词以英文 , 隔开</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">分类描述</label>
                    <div class="col-sm-5">
                        <textarea name="description" class="form-control" id="description">{{ isset($category['description']) ? $category['description'] : ''}}</textarea>
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger"></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">显示状态</label>
                    <div class="col-sm-5">
                        @foreach( $cateModel->getStatus('status') as $key => $val)
                        <label class="radio-inline">
                            <input type="radio" name="status" value="{{ $key }}"
               {{ isset($category['status']) && $category['status'] == $key ? 'checked' : '' }}
                            /> {{ $val }}
                        </label>
                        @endforeach
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{ $errors->first('status') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">分类属性</label>
                    <div class="col-sm-5">
                        @foreach( $cateModel->getStatus('channel') as $key => $val)
                            <label class="radio-inline">
                                <input type="radio" name="ischannel" value="{{ $key }}"
                                        {{ isset($category['ischannel']) && $category['ischannel'] == $key ? 'checked' : '' }} /> {{ $val }}
                            </label>
                        @endforeach
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{ $errors->first('ischannel') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@stop

@section('script')
@if(!isset($category))
    <script>
        $('input[name="status"]').val([1]);
        $('input[name="ischannel"]').val([0]);
    </script>
    @endif
@stop