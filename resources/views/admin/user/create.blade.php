@extends('admin.layouts.header')
@section('title', 'Add New User')
@section('content')
    <form class="row g-3" method="POST" action="{{ route('user.store') }}">
        @csrf

        @if(count($errors) > 0)
            <div class="col-md-4 mb-3 disabled">
                <label for="inputEmail3" class="form-label">Email</label>
                <input type="email" class="form-control disabled" id="inputEmail3" value="" name="email">
                <p class="text-danger m-0 mt-2">{{ $errors->get('email')[0] }}</p>
            </div>
            <div class="col-md-8">
            </div>
            <div class="col-md-4 mb-3">
                <label for="inputEmail4" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="inputEmail4">
                <p class="text-danger m-0 mt-2">{{$errors->get('name')[0]}}</p>
            </div>
            <div id="password" class="input-group mb-3 col-md-4">
                <input type="password" class="form-control" name="password" aria-describedby="basic-addon1">
                <span class="input-group-text" id="basic-addon1">
                    <i class="material-icons toggle_off">&#xe9f5;</i>
                </span>
                <div class="col-12 p-0">
                    <p class="text-danger m-0 mt-2">{{ $errors->get('password')[0] }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputState" class="form-label">State</label>
                <select id="inputState" name="status" class="form-control form-select">
                    <option value="1">Active</option>
                    <option value="0" selected>Disable</option>
                </select>
                <p class="text-danger m-0 mt-2">{{ $errors->get('status')[0] }}</p>
            </div>
            <div class="col-12 text-right">
                <button type="submit" class="btn btn-outline-primary">Add</button>
            </div>
        @endif
    </form>
@endsection
