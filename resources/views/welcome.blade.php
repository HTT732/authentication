@extends('auth.template')
@section('title', 'Home')
@section('content')
    @if(session('login'))
        <form class="box">
            <div class="col-md-12 mx-auto text-center">
                <h1>Logined!</h1>
                <a href="{{ route('logout') }}" class="btn btn-danger mt-3"><strong>Logout</strong></a>
            </div>
        </form>
    @else
        <form class="box">
            @if(session('message'))
                <p class="text-success">{{ session('message') }}</p>
            @endif
            <div class="col-md-12 mx-auto text-center">
                <a href="{{ route('show-login-form') }}" class="btn btn-danger mt-3 mx-2"><strong>Login</strong></a>
                <a href="{{ route('show-register-form') }}" class="btn btn-warning mt-3 mx-2"><strong>Register</strong></a>
            </div>
        </form>
    @endif
@endsection
