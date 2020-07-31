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

    {{-- Main Content --}}

    <div class="modal fade" id="login-modal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h5 class="modal-title">Login</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">

            <div class="signin">
              <form method="post">
                <input type="text" placeholder="User Name">
                <input type="password" placeholder="Password">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" checked="checked"><i class="check-box"></i>
                    <span>Remember Me</span>
                  </label>
                </div>
                <button type="submit">Log In</button>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- Scripts --}}
  <script src="{{ url('assets/js/main.min.js') }}"></script>
  <script src="{{ url('assets/js/script.js') }}"></script>
</body>

</html>