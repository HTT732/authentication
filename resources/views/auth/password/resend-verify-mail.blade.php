@extends('auth.template')
@section('title', 'Resend Link')
@section('content')
    <form class="box" method="post" action="{{ route('post-resend-email') }}">
        @csrf
        <h1>Resend link</h1>
        @if(count($errors) > 0)
            @foreach($errors->all() as $err)
                <p class="text-danger"> {{ $err }}</p>
            @endforeach
        @else
            <p class="text-muted">Please enter your email!</p>
        @endif
        <input type="text" name="email" placeholder="Email" value="{{old('email')}}">
        <input type="submit" name="" value="Submit">
    </form>
@endsection
