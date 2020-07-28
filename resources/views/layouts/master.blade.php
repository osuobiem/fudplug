<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
	<title>Pitnik Social Network Toolkit</title>
    <link rel="icon" href="{{ url('assets/images/fav.png') }}" type="image/png" sizes="16x16"> 
    
    <link rel="stylesheet" href="{{ url('assets/css/main.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/color.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/custom.css') }}">

</head>

<body>

  {{-- Preloader Component --}}
  @include('components.preloader')
  
  {{-- Main Content --}}
  <div class="theme-layout">

    {{-- Header Component --}}
    @include('components.header')

  </div>

  {{-- Scripts --}}
  <script src="{{ url('assets/js/main.min.js') }}"></script>
	<script src="{{ url('assets/js/script.js') }}"></script>
</body>
</html>