@extends('layouts.app')

@section('title', '编辑个人资料')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">编辑个人资料</div>
                    <div class="card-body">
                        <form action="{{ route('users.update', $user) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            @include('shared._errors')

                            <div class="form-group">
                                <label for="name">用户名</label>
                                <input class="form-control" id="name" name="name" type="text" value="{{ old('name', $user->name) }}">
                            </div>

                            <div class="form-group">
                                <label for="avatar">用户头像</label>
                                <input class="form-control-file" type="file" name="avatar" id="avatar">
                                <img class="mt-2 mw-100" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                            </div>

                            <button type="submit" class="btn btn-primary">提交</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
