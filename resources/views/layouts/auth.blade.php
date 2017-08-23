<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @section("title")
            Working Hours
        @show
    </title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="{{ asset("/css/util.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css">

    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
            cursor: pointer;
        }
    </style>

    @stack("styles")
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @if (Auth::check())
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ url('/login') }}" data-underline-if="/login">Login</a>
                @if(\App\User::count() === 0)
                    <a href="{{ url('/register') }}" data-underline-if="/register">Register</a>
                @endif
            @endif
        </div>
    @endif

    <div class="content">
        @yield("content")
    </div>
</div>
@stack("scripts")
<script src="{{ asset("/js/util.js") }}"></script>
</body>
</html>
