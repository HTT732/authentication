@extends('admin.layouts.header')
@section('title', 'User Management')
@section('content')
    <div class="row">
        <div class="col-6 d-flex align-items-center">
            @error('errorMessage')
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="material-icons warning">&#xe002;</i>
                <p class="m-0 ml-3">{{$message}} </p>
            </div>
            @enderror

            @if(session('successMessage'))
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="material-icons check">&#xe5ca;</i>
                    <p class="m-0 ml-3">{{session('successMessage')}} </p>
                </div>
            @endif

            @if(!empty($messFound))
                <p class="m-0 ml-3">{!! $messFound !!}</p>
            @elseif(!empty($messNotFound))
                <p class="m-0 ml-3">{!! $messNotFound !!} </p>
            @else
            @endif
        </div>
        <div class="col-6">
            @include('admin.layouts.search')
        </div>
    </div>

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
                            <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="settings" title="Edit" data-toggle="tooltip"><i class="material-icons edit">&#xe3c9;</i></a>
                            <form action="{{ route('user.destroy', ['user' => $user->id]) }}" method="post" class="d-inline-block delete-form m-0">
                                @csrf
                                @method('DELETE')
                                <a href="#" data-bs-toggle="modal" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE5C9;</i></a>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="text-center">
                    <td colspan="6" class="pt-4 pb-0">
                        <h6>Not found user</h6>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    {{$users->onEachSide(1)->links('admin.layouts.pagination')}}

    <!-- Modal confirm delete -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <strong>Are you sure you want to delete it?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn no-delete" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary yes-delete">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var myModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'), {
            keyboard: false
        });

        $(document).ready(function () {
            $('.delete').click(function (e) {
                $this = $(this);
                e.preventDefault();
                myModal.show();

                $('.no-delete').click(function () {
                    myModal.hide();
                });

                $('.yes-delete').click(function () {
                    $this.closest('form').submit();
                    myModal.hide();
                });
            })
        });

    </script>
    @push('script')
        <script src="{{ asset('admin/js/user/index.js') }}"></script>
    @endpush
@endsection
@extends('admin.layouts.footer')
