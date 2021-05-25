@extends('auth.template')
@section('title', 'Home')
@section('content')
    @if(session('login'))
        <form class="box">
            <div class="text-left text-warning mb-3"><h5 style="font-style:italic">Welcome, {{ session('name') }}</h5></div>
            <div class="col-md-12 mx-auto text-center">
                <h1>Logged In!</h1>
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
@section('content2')
    <div class="col-12" style="margin-top:30%">
        <h3 style="color:#fff">Send message to user</h3>
        @if(count($errors) > 0)
            <div class="alert alert-danger w-50 mt-3" role="alert">
                @foreach($errors->all() as $err)k
                    <li>{{$err}}</li>
                @endforeach
            </div>
        @endif
        <form action="{{route('send-message')}}" method="post" class="mt-4">
            @csrf
            <label for="" class="text-success text-bold mr-2"><strong>Email</strong> </label><input type="text" name="email">
            <label for="" class="text-success text-bold mr-2 ml-4"><strong>Message</strong> </label><input type="text" name="mess">
            <input type="submit" value="Send">
        </form>
        @if(session('success'))
            <div class="alert alert-success w-25 mt-3" role="alert">
                {{session('success')}}
            </div>
        @endif
    </div>
@endsection
