<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'HOME') - {{ config('app.name') }}</title>


    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">

    @yield('css')

    <style>

        .navbar {
            margin-bottom: 50px;
        }

        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #606c76;
        }

        .navbar li {
            float: left;
            margin-bottom: 0;
        }

        .navbar li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar li a:hover {
            background-color: #ab5dda;
        }

        textarea {
            margin-top: 0;
            margin-bottom: 15px;
            height: 250px;
        }


    </style>

</head>
<body>


<nav class="navbar">
    <ul>
        <li><a class="active" href="{{ route('home') }}">Home</a></li>
    </ul>
</nav>
<div class="container">

    {{-- お知らせメッセージ --}}
    @if(Session::has('message'))
        <div class="alert alert-info">{!! Session::get('message') !!}</div>
    @endif

    {{-- content --}}
    @yield('content')

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

@yield('js')

</body>
</html>
