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
            <div class="col-md-6">
                <div class="card">
                    <form class="box" method="post" action="{{ route('update-password') }}">
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
                </div>
            </div>
        </div>
    </div>
    </body>
</html>
