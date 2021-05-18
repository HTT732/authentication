@extends('admin.layouts.header')
@section('title', 'Edit User')
@section('content')
    <form class="row g-3" action="{{ route('user.update', ['user' => $id]) }}">
        <div class="col-md-4 mb-3 disabled">
            <label for="inputEmail3" class="form-label">Email</label>
            <input type="email" class="form-control disabled" id="inputEmail3" value="admin@admin.com" disabled readonly>
        </div>
        <div class="col-md-8">
        </div>
        <div class="col-md-4 mb-3">
            <label for="inputEmail4" class="form-label">Name</label>
            <input type="email" class="form-control" id="inputEmail4">
        </div>
        <div class="col-md-4">
            <label for="inputPassword4" class="form-label">Password</label>
            <input type="password" class="form-control" id="inputPassword4">
        </div>
        <div class="col-md-4">
            <label for="inputState" class="form-label">State</label>
            <select id="inputState" class="form-control form-select">
                <option value="1">Active</option>
                <option value="0" selected>Disable</option>
            </select>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Save change</button>
        </div>
    </form>
@endsection
