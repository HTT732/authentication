@extends('auth.template')
@section('title', 'Forgot password')
@section('content')
    <form class="box" method="post" action="{{ route('forgot-password.store') }}">
        @csrf
        @if(session('message'))
            <p class="text-success">{{session('message')}}</p>
            <p class="text-muted">
                If you do not receive the link,
                <a href="{{ route('forgot-password.index') }}" class="text-muted">
                    <strong>click to resend</strong>
                </a>
            </p>
            <a href="{{ route('login.index') }}" class="btn btn-danger mt-3 mx-2"><strong>Login</strong></a>
        @else
            <h1>Forgot password</h1>
            @if(count($errors) > 0)
                @foreach($errors->all() as $err)
                    <p class="text-danger"> {{ $err }}</p>
                @endforeach
            @else
                <p class="text-muted">Please enter your email!</p>
            @endif
            <input type="text" name="email" placeholder="Email" value="{{old('email')}}">
            <input type="submit" name="" value="Submit">
        @endif
    </form>
@endsection
