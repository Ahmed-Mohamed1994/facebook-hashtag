@extends('layouts.master')

@section('title')
    post
@endsection

@section('style')
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
@endsection

@section('content')
    @include('includes.message-block')

    <section class="row posts">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>Posts</h3></header>
            <article class="post">
                <div class="media-left">
                    <a href="{{ route('profile',['user' => $post->user_id]) }}">
                        <img class="media-object image-post"
                             src="{{ Storage::url($post->user->image) }}" alt="image">

                    </a>
                </div>
                <div class="media-right">
                    <p>{!! $post->body !!}</p>
                    <div class="info">
                        Posted by <a
                                href="{{ route('profile',['user' => $post->user_id]) }}">{{ $post->user->name }}</a>
                        {{ $post->created_at->diffForHumans() }} <span class="glyphicon glyphicon-time"></span>
                    </div>
                    <div class="interaction">
                        @if(Auth::user()->id == $post->user_id && Auth::user()->type == "USER")
                            <a href="{{ route('editPost',['post' => $post->id]) }}">Edit</a> |
                            <a href="{{ route('deletePost',['post' => $post->id]) }}">Delete</a>
                        @endif
                        @if(Auth::user()->id == $post->user_id && Auth::user()->type == "ADMIN")
                            <a href="{{ route('editPost',['post' => $post->id]) }}">Edit</a> |
                        @endif
                        @if(Auth::user()->type == "ADMIN")
                            <a href="{{ route('deletePost',['post' => $post->id]) }}">Delete</a>
                        @endif
                    </div>
                </div>
            </article>
            @foreach($post->comments as $comment)
                <div class="media">
                    <div class="comment">
                        <div class="media-left">
                            <a href="{{ route('profile',['user' => $comment->user_id]) }}">
                                <img class="media-object image-post"
                                     src="{{ Storage::url($comment->user->image) }}" alt="image">
                            </a>
                        </div>
                        <div class="media-body">
                            <strong>{{ $comment->user->name }}</strong>
                            <p>{!! $comment->body !!}</p>
                            <p class="comment_time">{{ $comment->created_at->diffForHumans() }}
                                <span class="glyphicon glyphicon-time"></span></p>
                            <div class="interaction">

                                @if($comment->user_id == Auth::user()->id && Auth::user()->type == "USER")
                                    <a href="{{ route('editComment',['comment' => $comment->id]) }}">Edit</a> |
                                    <a href="{{ route('deleteComment',['comment' => $comment->id]) }}">Delete</a>
                                @endif
                                @if(Auth::user()->id == $comment->user_id && Auth::user()->type == "ADMIN")
                                    <a href="{{ route('editComment',['comment' => $comment->id]) }}">Edit</a> |
                                @endif
                                @if(Auth::user()->type == "ADMIN")
                                    <a href="{{ route('deleteComment',['comment' => $comment->id]) }}">Delete</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <hr>
            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form method="post" action="{{ route('storeComment', ['post' => $post->id ]) }}">
                    <div class="form-group">
                        <textarea class="form-control" rows="3" name="comment" id="comment"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Comment</button>
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </section>


@endsection

@section('script')
    <script type="application/javascript">
        window.onhashchange = function () {
            var hash = window.location.hash.substring(1);
            var url = '{{ route("hashTag", ":hashTag") }}';
            url = url.replace(':hashTag', hash);
            window.location.href = url;
        };
    </script>
@endsection