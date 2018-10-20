@extends('layouts.master')

@section('title')
    update comment
@endsection

@section('content')
    @include('includes.message-block')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h3>Edit Comment</h3>
            <form action="{{ route('updateComment' ,['comment' => $comment->id]) }}" method="post">
                <div class="form-group  {{ $errors->has('comment') ? 'has-error' : '' }}">
                    <textarea class="form-control" name="comment" id="comment"
                              rows="5">{{ $comment->body }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
@endsection