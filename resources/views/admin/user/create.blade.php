@extends('admin.layouts.header')
@section('title', 'Add New User')
@section('content')
    <form class="row g-3" method="POST" action="{{ route('user.store') }}">
        @csrf
        <div class="col-md-6 mb-3">
            <label for="inputEmail3" class="form-label">Email</label>
            <input type="email" class="form-control" id="inputEmail3" value="{{old('email')}}" name="email" autofocus>
            @error('email')
                <p class="text-danger m-0 mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="inputEmail4" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="inputEmail4" value="{{old('name')}}">
            @error('name')
                <p class="text-danger m-0 mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div id="passwordCreate" class="password input-group mb-3 col-md-6">
            <label for="inputPassword5" class="form-label">Password</label>
            <div class="input-group">
                <input id="inputPassword5" type="password" class="form-control" name="password" aria-describedby="basic-addon1" >
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
            <select id="inputState" name="status" class="form-control form-select">
                <option value="1">Active</option>
                <option value="0" selected>Disable</option>
            </select>
            @error('status')
                <p class="text-danger m-0 mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="col-6 text-left">
            @error('errorMessage')
                <p class="text-danger m-0 mt-2">{{ $message }}</p>
            @enderror
            @if(session('successMess'))
                <p class="text-success m-0 mt-2">{{ session('successMess') }}</p>
            @endif
        </div>
        <div class="col-6 text-right">
            <button type="submit" class="btn btn-outline-primary">Add</button>
        </div>

    </form>
@endsection
