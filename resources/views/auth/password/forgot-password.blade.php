@extends('auth.template')
@section('title', 'Forgot password')
@section('content')
    <form class="box" method="post" action="{{ route('post-forgot-password') }}">
        @csrf
        @if(session('message'))
            <p class="text-primary">{{session('message')}}</p>
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
