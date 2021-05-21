@extends('admin.layouts.header')
@section('title', 'Show')
@section('content')
    @if($user)
    <div class="show-info card mb-3 border-0">
        <div class="row g-0">
            <div class="col-md-3">
                <img src="{{ asset('admin/media/users/avatar.jpg') }}" alt="{{$user->name}}" class="img-fluid w-100" style="border: 1px solid #dfdfdf">
            </div>
            <div class="col-md-9">
                <div class="card-body row">
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Name</label>
                        <p class="" id="inputEmail4"><strong>{{$user->name}}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Email</label>
                        <p class="" id="inputEmail4"><strong>{{$user->email}}</strong></p>
                    </div>
                    <div class="col-md-6 mt-1">
                        <label for="inputPassword4" class="form-label">Created date</label>
                        <p class="" id="inputEmail4"><strong>{{$user->created_at}}</strong></p>
                    </div>
                    <div class="col-md-6 mt-1">
                        <label for="inputPassword4" class="form-label">Activation date</label>
                        <p class="" id="inputEmail4"><strong>{{!empty($user->email_verified_at) ? $user->email_verified_at : 'Not activate' }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card mb-3 border-0">
        <p class="text-danger">Not found user</p>
    </div>
    @endif
@endsection
