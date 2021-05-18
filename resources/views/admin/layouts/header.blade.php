<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('admin/css/admin-style.css')}}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();

            $('#password span').click(function () {
                $el = $(this).find('i');
                if ($el.hasClass('toggle_off')) {
                    $el.html('&#xe9f6;');
                    $el.removeClass('toggle_off');
                    $el.addClass('toogle_on');
                    $el.css('color', '#299be4');
                    $('#password input').attr('type', 'text');
                } else {
                    console.log('else')
                    $el.html('&#xe9f5;');
                    $el.removeClass('toogle_on');
                    $el.addClass('toggle_off');
                    $el.css('color', '#000');
                    $('#password input').attr('type', 'password');
                }

            })
        });
    </script>
</head>
<body>
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5 d-flex">
                        <a href="{{route('user.index')}}" class="btn btn-secondary mr-3"><i class="material-icons home">&#xe88a;</i></a>
                        <h2><b>@yield('title')</b></h2>
                    </div>
                    <div class="col-sm-7">
                        <a href="{{ route('user.create') }}" class="btn btn-secondary"><i class="material-icons">&#xE147;</i> <span>Add New User</span></a>
                    </div>
                </div>
            </div>

            @yield('content')
