<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" type="image/png" href="{{ url('assets/img/fav.png') }}">
    <title>@yield('title')fudplug</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ url('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ url('assets/css/uikit.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/animate.min.css') }}" />
    <!-- Feather Icon-->
    <link href="{{ url('assets/vendor/line-awesome-1.3.0/1.3.0/css/line-awesome.min.css') }}" rel="stylesheet"
        type="text/css">

    <link href="{{ url('assets/css/light.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ url('assets/css/custom.css') }}" rel="stylesheet">

    <script src="{{ url('assets/vendor/jquery/jquery.min.js') }}"></script>

    <script src="{{ url('assets/vendor/jquery-cookie/jquery-cookie.js') }}"></script>

    <!-- Emoji -->
    <link href="{{ url('assets/vendor/emojionearea/emojionearea.min.css') }}" rel="stylesheet">
    <script src="{{ url('assets/vendor/emojionearea/emojionearea.min.js') }}"></script>

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
        <div class="row main-section">

            <!-- Left Sidebar -->
            @if(!Auth::guest())
            @include('vendor.components.left-side')

            @elseif(!Auth::guard('user')->guest())
            @else
            @endif

            <!-- Main Content -->
            <main class="col col-md-10 col-lg-6" id="main-content">
                @yield('content')

                {{-- Dish Addition Modal--}}
                @include('vendor.components.dish-add')

                <!-- Dish View Modal Holder -->
                <div id="dish-modal-holder">

                </div>
                <!-- Dish View Modal Holder -->

                <!-- Dish Delete Modal Holder -->
                <div id="dish-delete-modal-holder">

                </div>
                <!-- Dish Delete Modal Holder -->

                <!-- Menu Update Modal Holder -->
                <div id="menu-modal-holder">

                </div>
                <!-- Menu Update Modal Holder -->
            </main>

            <!-- Right Sidebar -->
            @if(!Auth::guest())
            <aside class="col col-lg-3 d-none d-lg-block side-section side-section-r right-side-large text-center">
                <div class="justify-content-center text-center w-100 pb-2 box shadow-sm border rounded bg-white p-2"
                    id="right-side-spinner" style="display: none;">
                    <p><strong>Loading...</strong></p>
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

            </aside>

            @elseif(!Auth::guard('user')->guest())
            @else
            @endif

        </div>
    </div>

    {{-- Location onboading --}}
    <button class="d-none" id="launchOnboarding" data-toggle="modal" data-target="#boardModal"></button>
    @if(!Auth::guest())

    {{-- Floating Post Buttons --}}
    <button class="btn btn-primary floating-post-btn d-none post-modal-init animate__animated">
        <i class="la la-utensil-spoon la-lg"></i>
        Post
    </button>

    <button class="btn btn-primary floating-post-btn-sm d-none d-lg-none post-modal-init animate__animated">
        <i class="la la-utensil-spoon la-2x"></i>
    </button>

    {{-- Check if vendor area is set --}}
    @if(!Auth::user()->area)
    @include('components.onboarding')
    <script>
        $(document).ready(function () {
            $("#launchOnboarding").click();
        });

    </script>
    @endif

    @elseif(!Auth::guard('user')->guest())
    {{-- Check if user area is set --}}
    @if(!Auth::guard('user')->user()->area)
    @include('components.onboarding')
    <script>
        $(document).ready(function () {
            $("#launchOnboarding").click();
        });

    </script>
    @endif
    @endif

    <!-- Bootstrap core JavaScript -->
    <script src="{{ url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- slick Slider JS -->
    <script type="text/javascript" src="{{ url('assets/vendor/slick/slick.min.js') }}"></script>
    <!-- Cropper.js -->
    <script src="{{ url('assets/js/cropper.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ url('assets/js/osahan.js') }}"></script>
    <script src="{{ url('assets/js/custom.js') }}"></script>

    {{-- Additional Scripts--}}
    @stack('scripts')
    <!-- jQuery Steps Plugin -->
    <script src="{{ url('assets/js/jquery-steps-master/build/jquery.steps.js') }}"></script>
    <script src="{{ url('assets/js/uikit.min.js') }}"></script>
    <script src="{{ url('assets/js/uikit-icons.min.js') }}"></script>

    {{-- Check for session availablity --}}
    @if(!Auth::guest() || !Auth::guard('user')->guest())
    <script src="{{ url('assets/js/logged-in.js') }}" server="{{ url('') }}"></script>
    @else
    <script src="{{ url('assets/js/not-logged-in.js') }}"></script>
    @endif
</body>

</html
