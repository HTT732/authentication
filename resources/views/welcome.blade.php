@extends('auth.template')
@section('title', 'Home')
@section('content')
    @if(session('login'))
        <form class="box">
            <div class="text-left text-warning mb-3"><h5 style="font-style:italic">Welcome, {{ session('name') }}</h5></div>
            <div class="col-md-12 mx-auto text-center">
                <h1>Logined!</h1>
                <a href="{{ route('user.index') }}" class="btn btn-primary mt-3 mr-3"><strong>User Management</strong></a>
                <a href="{{ route('logout') }}" class="btn btn-danger mt-3"><strong>Logout</strong></a>
            </div>
        </form>
    @else
        <form class="box">
            @if(session('message'))
                <p class="text-success">{{ session('message') }}</p>
            @endif
            <div class="col-md-12 mx-auto text-center">
                <a href="{{ route('login.index') }}" class="btn btn-danger mt-3 mx-2"><strong>Login</strong></a>
                <a href="{{ route('register.index') }}" class="btn btn-warning mt-3 mx-2"><strong>Register</strong></a>
            </div>
        </form>
    @endif
@endsection
