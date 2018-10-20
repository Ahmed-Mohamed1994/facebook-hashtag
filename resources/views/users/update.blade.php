@extends('layouts.master')

@section('title')
    update user
@endsection

@section('content')
    @include('includes.message-block')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h3>Edit User</h3>
            <form action="{{ route('updateUser' ,['user' => $user->id]) }}" method="post">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">Name</label>
                    <input class="form-control" type="text" name="name" id="name"
                           value="{{  Request::old('name') ? Request::old('name') : isset($user) ? $user->name : '' }}">
                </div>

                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email"
                           value="{{  Request::old('email') ? Request::old('email') : isset($user) ? $user->email : '' }}">
                </div>

                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
@endsection