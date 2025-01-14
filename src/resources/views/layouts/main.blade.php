<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <title>@yield('title', 'OLX')</title>
</head>
<body>
<header class="mt-3">
    <nav class="">
        <ul class="d-flex flex-row justify-content-around">
            <li>
                <a href="{{route('home')}}">HOME</a>
            </li>

            @if (Route::has('login'))
                @auth
                    <li><a href="{{ route('dashboard') }}"> Dashboard </a></li>
                    <li><a href="{{ route('logout') }}"> Logout </a></li>
                @else
                    <li><a href="{{ route('login') }}"> Log in </a></li>

                    <li><a href="{{ route('register') }}"> Register </a></li>

                @endauth
            @endif
        </ul>
    </nav>
</header>
<main class="main mt-3">
    <div class="container">
        {{--        @if($errors->any())--}}
        {{--            <div class="alert alert-danger">--}}
        {{--                <ul>--}}
        {{--                    @foreach($errors->all() as $error)--}}
        {{--                        <li>{{$error}}</li>--}}
        {{--                    @endforeach--}}
        {{--                </ul>--}}
        {{--            </div>--}}

        {{--        @endif--}}
        @if(session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @endif
        @yield('content')
    </div>

</main>

</body>
</html>
