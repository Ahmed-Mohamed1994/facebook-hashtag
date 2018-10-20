@extends('layouts.master')

@section('title')
    update post
@endsection

@section('content')
    @include('includes.message-block')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h3>Edit Post</h3>
            <form action="{{ route('updatePost' ,['post' => $post->id]) }}" method="post">
                <div class="form-group  {{ $errors->has('post') ? 'has-error' : '' }}">
                    <textarea class="form-control" name="post" id="post"
                              rows="5">{{ $post->body }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
@endsection