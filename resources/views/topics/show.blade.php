@extends('layouts.app')

@section('title', $topic->title)
@section('description', $topic->summary)

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ $backUrl }}">
                            <i class="fa fa-arrow-left fa-2x"></i>
                        </a>
                        <div class="text-center">
                            <h3>
                                {{ $topic->title }}
                            </h3>
                            <small class="text-secondary">
                                <i class="far fa-folder"></i>
                                {{ $topic->category->name ?? '未知' }}
                                &bull;
                                <i class="far fa-user"></i>
                                {{ $topic->user->name }}
                                &bull;
                                <i class="far fa-eye"></i>
                                {{ $topic->view_count }}
                                &bull;
                                <i class="far fa-clock" title="最后修改于{{ $topic->updated_at }}"></i>
                                {{ $topic->updated_at->diffForHumans() }}
                            </small>
                        </div>

                        <div class="topic-body mt-4">
                            {!! $topic->content !!}
                        </div>
                        @can('operate', $topic)
                            <hr>
                            <div>
                                <a href="{{ route('topics.edit', $topic) }}" class="btn btn-sm btn-primary mr-2">
                                    <i class="far fa-edit"></i>
                                    编辑
                                </a>
                                <a href="#" data-fn="confirm" data-title="确定删除？" class="btn btn-sm btn-danger">
                                    <i class="far fa-trash-alt"></i>
                                    删除
                                </a>
                                <form action="{{ route('topics.destroy', $topic) }}" method="post">
                                    @csrf
                                    @method('delete')
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop
