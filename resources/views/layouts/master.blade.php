<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" type="image/png" href="{{ url('assets/img/fav.png') }}">
    <title>@yield('title')fudplug</title>

    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/animate.min.css') }}" />
    <!-- Feather Icon-->
    <link href="{{ url('assets/vendor/line-awesome-1.3.0/1.3.0/css/line-awesome.min.css') }}" rel="stylesheet"
        type="text/css">
    <!-- Bootstrap core CSS -->
    <link href="{{ url('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ url('assets/css/light.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ url('assets/css/custom.css') }}" rel="stylesheet">

    <script src="{{ url('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('assets/vendor/jquery-cookie/jquery-cookie.js') }}"></script>
</head>

<body>

    {{-- Check for session availablity --}}
    @if(!Auth::guest()) 
        @include('vendor.components.header')
    
    @elseif(!Auth::guard('user')->guest()) 
        @include('user.components.header')
    
    @else 
        @include('components.header')
        @include('components.login')
        @include('components.signup')
    @endif

    <div class="container-fluid">
        <div class="row">

            {{-- Left Section --}}
            <div class="col-lg-3 side-section px-1">
                @section('left-section')
                @show
            </div>

        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- slick Slider JS-->
    <script type="text/javascript" src="{{ url('assets/vendor/slick/slick.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ url('assets/js/osahan.js') }}"></script>
    <script src="{{ url('assets/js/custom.js') }}"></script>
</body>

</html