@extends('admin.layouts.header')
@section('title', 'User Management')
@section('content')
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Date Created</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if(count($users) > 0)
                @foreach($users as $key => $user)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td><a href="#"><img src="{{asset('admin/media/users/avatar.jpg')}}" class="avatar" alt="Avatar">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_date }}</td>
                        @if(empty($user->email_verified_at))
                            <td><span class="status text-danger">&bull;</span>
                                Disable
                            </td>
                        @else
                            <td><span class="status text-success">&bull;</span>
                                Active
                            </td>
                        @endif
                        <td>
                            <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="settings" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE8B8;</i></a>
                            <a href="{{ route('user.destroy', ['user' => $user->id]) }}" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE5C9;</i></a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <h5>Not found user</h5>
                </tr>
            @endif
        </tbody>
    </table>
    {{$users->onEachSide(1)->links('admin.layouts.pagination')}}
@endsection
@extends('admin.layouts.footer')
