<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

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
                    @yield('content')
                </div>
            </div>
    </div>
</div>

</body>
</html>
