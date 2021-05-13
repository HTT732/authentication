<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        {{-- css--}}
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
{{--        <link href='https://use.fontawesome.com/releases/v5.8.1/css/all.css'>--}}
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        {{--  script--}}
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
        <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js'></script>
    </head>
    <body class="antialiased">
    <div class="container">
        <div class="row">
            @if(!Auth::check())
            <div class="col-md-6">
                <div class="card">
                    <form class="box" method="post" action="{{ route('login') }}">
                        @csrf
                        <h1>Login</h1>
                        @if (count($errors) > 0)
                            @foreach($errors->all() as $err)
                                <p class="text-danger"> {{ $err }}</p>
                            @endforeach
                        @elseif(session('message'))
                            <p class="text-success">{{ session('message') }}</p>
                        @else
                            <p class="text-muted">Please enter your login and password!</p>
                        @endif

                        <input type="text" name="email" placeholder="Email" value="{{old('email')}}">
                        <input type="password" name="password" placeholder="Password">
                        <a class="forgot text-muted" href="{{ route('get-forgot-password') }}">Forgot password?</a>
                        <input type="submit" name="" value="Login">
                        <div class="col-md-12">
{{--                            <ul class="social-network social-circle">--}}
{{--                                <li><a href="#" class="icoFacebook" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>--}}
{{--                                <li><a href="#" class="icoTwitter" title="Twitter"><i class="fab fa-twitter"></i></a></li>--}}
{{--                                <li><a href="#" class="icoGoogle" title="Google +"><i class="fab fa-google-plus"></i></a></li>--}}
{{--                            </ul>--}}
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="logined col-md-6 mx-auto text-center">
                <h1>Logined!</h1>
                <a href="{{ route('logout') }}" class="btn btn-danger mt-3"><strong>Logout</strong></a>
            </div>
            @endif
        </div>
    </div>

    </body>
</html>
