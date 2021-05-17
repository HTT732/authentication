@extends('auth.template')
@section('title', 'Register')
@section('content')
    <form class="box" method="post" action="{{ route('register.store') }}">
        @csrf
        <h1>Register</h1>
        @if (count($errors) > 0)
            @foreach($errors->all() as $err)
                <p class="text-danger"> {{ $err }}</p>
            @endforeach
        @elseif(session('message'))
            <p class="{{ session('class-color') }}">{{ session('message') }}</p>
        @endif

        <input type="text" name="name" placeholder="Name" value="{{old('name')}}">
        <input class="mb-1" type="text" name="email" placeholder="Email" value="{{old('email')}}">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="password_confirmation" placeholder="Confirm password">
        <input type="submit" name="" value="Register">
        <p class="text-muted">Already have an account <a class="text-muted" href="{{ route('login.index') }}"><strong>Login</strong></a></p>
    </form>
@endsection
