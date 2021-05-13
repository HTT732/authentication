@extends('auth.template')
@section('title', 'Register')
@section('content')
    <form class="box" method="post" action="{{ route('login') }}">
        @csrf
        <h1>Register</h1>
        @if (count($errors) > 0)
            @foreach($errors->all() as $err)
                <p class="text-danger"> {{ $err }}</p>
            @endforeach
        @elseif(session('message'))
            <p class="text-success">{{ session('message') }}</p>
        @endif

        <input type="text" name="name" placeholder="Name" value="{{old('name')}}">
        <input type="text" name="email" placeholder="Email" value="{{old('email')}}">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="password_confirmation" placeholder="Confirm password">
        <p class="text-muted">Already have an account <a class="forgot text-muted" href="{{ route('show-login-form') }}"><strong>Login</strong></a></p>
        <input type="submit" name="" value="Register">
    </form>
@endsection
