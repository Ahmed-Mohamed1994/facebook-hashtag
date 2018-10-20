@extends('layouts.master')

@section('title')
    home
@endsection

@section('style')
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
@endsection

@section('content')
    @include('includes.message-block')
    <section class="row new-post">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>What do you have to say?</h3></header>
            <form action="{{ route('storePost') }}" method="post">
                <div class="form-group  {{ $errors->has('post') ? 'has-error' : '' }}">
                    <textarea class="form-control" name="post" id="post" rows="5"
                              placeholder="Your Post">{{ Request::old('post') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create Post</button>
                {{ csrf_field() }}
            </form>
        </div>
    </section>

    <hr>
    @if($posts)
        <section class="row posts">
            <div class="col-md-6 col-md-offset-3">
                <header><h3>Posts</h3></header>
                @foreach($posts as $post)
                    <article class="post well">
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
                                <a href="{{ route('showPost',['post' => $post->id]) }}">View</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif


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