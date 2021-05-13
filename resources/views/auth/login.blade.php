@extends('auth.template')
@section('title', 'Login')
@section('content')
<form class="box" method="post" action="{{ route('login') }}">
    @csrf
    <h1>Login</h1>
    @if (count($errors) > 0)
        @foreach($errors->all() as $err)
            <p class="text-danger"> {{ $err }}</p>
        @endforeach
    @elseif(session('message'))
        <p class="text-success">{{ session('message') }}</p>
    @else
        <p class="text-muted">Please enter your login and password!</p>
    @endif

    <input type="text" name="email" placeholder="Email" value="{{old('email')}}">
    <input type="password" name="password" placeholder="Password">
    <a class="forgot text-muted" href="{{ route('get-forgot-password') }}">Forgot password?</a>
    <input type="submit" name="" value="Login">
</form>
@endsection
