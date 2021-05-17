@extends('auth.template')
@section('title', 'Reset password')
@section('content')
    <form class="box" method="post" action="{{ route('reset-password.store') }}">
        @csrf
        <h1>Reset password</h1>
        @if(!empty($errors))
            @foreach($errors->all() as $err)
                <p class="text-danger">{{ $err }}</p>
            @endforeach
        @endif

        @if(session('error'))
            <p class="text-danger">{{ session('error') }}</p>
        @endif
        <input type="hidden" name="token" value={{ $token }}>
        <input type="password" name="password" placeholder="New password">
        <input type="password" name="password_confirmation" placeholder="Confirm password">
        <input type="submit" name="" value="Reset password">
    </form>
@endsection
