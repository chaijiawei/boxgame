@extends('layouts.app')

@section('title', $category->name ?? '话题列表')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                @if($category)
                    <div class="alert alert-info">
                        {{ $category->name }}：{{ $category->description }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        话题列表
                    </div>
                    <div class="card-body">
                        @if(count($topics) > 0)
                            <ul class="list-unstyled">
                                @foreach($topics as $topic)
                                    <li class="media @if(! $loop->first) my-4 @endif">
                                        <img width="40" class="mr-2" src="{{ $topic->user->avatar }}" alt="{{ $topic->user->name }}">
                                        <div class="media-body">
                                            <a class="text-body" href="{{ $topic->link() }}">
                                                <h5 class="d-inline">{{ $topic->title }}</h5>
                                            </a>
                                            <div>
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
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="mt-4">
                                {{ $topics->appends(Request::all())->links() }}
                            </div>
                        @else
                            @include('shared._no_data')
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                @include('topics._sidebar')
            </div>
        </div>
    </div>
@stop
