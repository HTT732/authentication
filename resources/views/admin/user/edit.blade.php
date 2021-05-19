@extends('admin.layouts.header')
@section('title', 'Edit User')
@section('content')
    <form class="row g-3" action="{{ route('user.update', ['user' => $user->id]) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="col-md-6 mb-3">
            <label for="inputEmail3" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="inputEmail3" value="{{$user->email}}">
            @error('email')
                <p class="text-danger m-0 mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="inputEmail4" class="form-label">Name</label>
            <input type="name" name="name" class="form-control" id="inputEmail4" value="{{$user->name}}">
            @error('name')
                <p class="text-danger m-0 mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div id="passwordEdit" class="password  mb-3 col-md-6">
            <label for="inputPassword4" class="form-label">Password</label>
            <div class="input-group">
                <input id="inputPassword4" type="password" class="form-control disabled" name="password" value="{{$user->password}}">
                <input type="hidden" id="inputHidden" value="{{$user->password}}">
                <span class="input-group-text" id="basic-addon1">
                <i class="material-icons toggle_off">&#xe9f5;</i>
            </span>
            </div>
            <div class="col-12 p-0">
                @error('password')
                <p class="text-danger m-0 mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <label for="inputState" class="form-label">State</label>
            <select id="inputState" class="form-control form-select" name="status">
                <option value="1" {{ $user->email_verified_at ?? 'selected' }}>Active</option>
                <option value="0" {{ $user->email_verified_at ?? 'selected' }}>Disable</option>
            </select>
            @error('status')
                <p class="text-danger m-0 mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="col-6 text-left">
            @error('errorMessage')
            <p class="text-danger m-0 mt-2">{{ $message }}</p>
            @enderror
            @if(session('update_success'))
                <p class="text-success m-0 mt-2">{{ session('successMess') }}</p>
            @endif
        </div>
        <div class="col-6 text-right">
            <button type="submit" class="btn btn-outline-primary">Save change</button>
        </div>
    </form>
@endsection
