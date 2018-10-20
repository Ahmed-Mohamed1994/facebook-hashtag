@extends('layouts.master')

@section('title')
    Account
@endsection

@section('style')
    <link rel="stylesheet" href="css/main.css">
@endsection

@section('content')
    @include('includes.message-block')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h3>Update</h3>
            <form action="{{ route('editAccount',['user' => $user->id]) }}" method="post" enctype="multipart/form-data">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">Your Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}">
                </div>

                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <label for="phone">Your Phone</label>
                    <input type="text" class="form-control" name="phone" id="phone" value="{{ $user->phone }}">
                </div>

                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    <label for="address">Your Address</label>
                    <input type="text" class="form-control" name="address" id="address" value="{{ $user->address }}">
                </div>

                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Your Email</label>
                    <input type="text" class="form-control" name="email" id="email" value="{{ $user->email }}">
                </div>

                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>

                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" class="form-control" id="image">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                {{ csrf_field() }}
            </form>
            <img src="{{ Storage::url($user->image) }}" alt="{{ $user->name }}" class="img-responsive account-image">
        </div>
    </div>
@endsection