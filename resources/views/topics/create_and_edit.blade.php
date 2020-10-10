@extends('layouts.app')

@section('title', $topic->id ? '编辑话题' : '创建话题')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $topic->id ? '编辑话题' : '创建话题' }}</div>
                    <div class="card-body">
                        <form action="{{ route($topic->id ? 'topics.update' : 'topics.store', $topic) }}" method="post">
                            @csrf
                            @include('shared._errors')
                            @if($topic->id)
                                @method('patch')
                            @endif

                            <div class="form-group">
                                <input type="text" value="{{ old('title', $topic->title) }}" name="title" class="form-control" placeholder="请填写标题">
                            </div>

                            <div class="form-group">
                                <select name="category_id" class="form-control">
                                    <option value="0" disabled selected>请选择分类</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                                @if(old('category_id', $topic->category_id) == $category->id) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <textarea id="editor" class="form-control" name="content" rows="5" placeholder="请填写话题内容">
                                    {!! old('content', $topic->content) !!}
                                </textarea>
                            </div>

                            <button class="btn btn-primary" type="submit">
                                {{ $topic->id ? '修改' : '发布' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@include('shared._simditor')

@push('scripts')
    <script>
        $(function() {
            new Simditor({
                textarea: $('#editor'),
                upload: {
                    url: '{{ route('topics.upload_image') }}',
                    params: {_token: '{{ csrf_token() }}'},
                    fileKey: 'upload_file',
                    connectionCount: 3,
                    leaveConfirm: '正在上传图片，确定离开？'
                },
                pasteImage: true
            });
        });
    </script>
@endpush

