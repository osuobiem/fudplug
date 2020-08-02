<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>fudplug</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/line-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/line-awesome-font-awesome.min.css') }}">
    <link href="{{ url('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/lib/slick/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/lib/slick/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/custom.css') }}">
</head>

<body>

    <div class="wrapper">

        {{-- Menu Component --}}
        @include('components.menu')


        {{-- Main Component --}}
        @yield('main')


        {{-- Modals --}}
        @include('components.modals')

        {{-- Login Modal --}}
        @include('components.login')

    </div>

    {{-- Scripts --}}
    <script type="text/javascript" src="{{ url('assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/popper.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/jquery.mCustomScrollbar.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/lib/slick/slick.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/scrollbar.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/script.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/custom.js') }}"></script>
</body>

</html>
