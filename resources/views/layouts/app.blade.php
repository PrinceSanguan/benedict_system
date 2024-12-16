<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SDG</title>
    @include('components.link')
</head>
@if(Route::is('login') || Route::is('reset') )
<body class="hold-transition login-page" style=" background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('assets/images/bg.jpg') }}'); background-size: cover; background-position: center;">
@else
<body class="hold-transition layout-top-nav">
@endif

    <div class="overlay" id="overlay"></div>

    <div class="loader-container" id="loaderContainer">
        <div class="circle-loader"></div>
    </div>

    @yield('content')

</body>
</html>
