@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/simditor.css') }}">
    @stop

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">

      <div class="card-header">
        <h1>
          话题 /
          @if($topic->id)
            编辑 #{{ $topic->id }}
          @else
            创建
          @endif
        </h1>
      </div>

      <div class="card-body">
        @if($topic->id)
          <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
          <input type="hidden" name="_method" value="PUT">
        @else
          <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
        @endif

          @include('common.error')

          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          
                <div class="form-group">
                	<label for="title-field">标题</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $topic->title ) }}" />
                </div> 
                <div class="form-group">
                	<label for="body-field">内容</label>
                	<textarea name="body" id="body-field" class="form-control" rows="3">{{ old('body', $topic->body ) }}</textarea>
                </div> 
                <div class="form-group">
                    <select class="form-control" name="category_id" required>
                        <option value="" hidden disabled selected>请选择分类</option>
                        @foreach ($categories as $value)
                            <option value="{{ $value->id }}" {{ $topic->category_id == $value->id?'selected':'' }}>{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
          <div class="well well-sm">
            <button type="submit" class="btn btn-primary">保存</button>
            <a class="btn btn-link float-xs-right" href="{{ route('topics.index') }}"> <- 返回</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
@section('scripts')
    <script src="{{ asset('js/module.min.js') }}"></script>
    <script src="{{ asset('js/hotkeys.min.js') }}"></script>
    <script src="{{ asset('js/uploader.min.js') }}"></script>
    <script src="{{ asset('js/simditor.min.js') }}"></script>
    <script>
        $(function (){
            var editor = new Simditor({
                textarea:$('#body-field'),
                upload: {
                    url: '{{ route('topics.upload_image') }}',
                    params: {
                        _token: '{{ csrf_token() }}'
                    },
                    fileKey: 'upload_file',
                    connectionCount: 3,
                    leaveConfirm: '文件上传中，关闭此页面将取消上传。'
                },
                pasteImage: true,
            })
        })
    </script>
    @stop
