@extends('layouts.master')

@section('title')
    Profile
@endsection

@section('style')
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <img src="{{ Storage::url($user->image) }}" alt="{{ $user->name }}" class="img-responsive account-image">
            <h2>Name: {{ $user->name }}</h2>
            <h4>Phone: {{ $user->phone }}</h4>
            <h4>Email: {{ $user->email }}</h4>
        </div>
    </div>
@endsection