@extends('auth.template')
@section('title', 'Login')
@section('content')
<form class="box" method="post" action="{{ route('login.store') }}">
    @csrf
    <h1>Login</h1>
    @if (count($errors) > 0)
        @foreach($errors->all() as $err)
            <p class="text-danger"> {{ $err }}</p>
        @endforeach
    @elseif(session('message'))
        <p class="text-success">{{ session('message') }}</p>
    @elseif(session('expire'))
        <p class="text-danger"> {{ session('expire') }} <a href="{{ route('resend.index') }}">click to resend</a></p>
    @elseif(session('not-found-link'))
        <p class="text-danger" >{{session('not-found-link')}}</p>
        <p class="text-danger">If you don't have the link yet, <a href="{{ route('resend.index') }}">click to resend</a></p>
    @elseif(session('verify-fail'))
        <p class="text-danger"> {{session('verify-fail')}} </p>
    @else
        <p class="text-muted">Please enter your login and password!</p>
    @endif

    <input type="text" name="email" placeholder="Email" value="{{old('email')}}">
    <input type="password" name="password" placeholder="Password">
    <div class="remember mb-3">
        <input class="form-check-input" type="checkbox" id="remember" name="remember">
        <label class="form-check-label text-secondary" for="remember">Remember me</label>
    </div>
    <input type="submit" name="" value="Login">
    <a class="text-muted mr-4" href="{{ route('forgot-password.index') }}">Forgot password?</a>
    <a class="text-muted ml-4" href="{{ route('register.index') }}">Register</a>
</form>
@endsection
