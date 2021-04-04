<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    @php
    // Node Server
    $node_server = env('NODE_SERVER');

    // Format Time/Date
    function format_time($time) {
    $time = strtotime($time);
    $t_diff = time() - $time;
    $res = "";

    if($t_diff < 60) { $res=$t_diff < 1 ? 'now' : $t_diff."s ago"; } elseif($t_diff>= 60 && $t_diff < 3600) {
            $res=(int)($t_diff/60)."m ago"; } elseif($t_diff>= 3600 && $t_diff < 86399) { $res=(int)($t_diff/3600)."h
                ago"; } elseif($t_diff>= 86400 && $t_diff < 604799) { $res=(int)($t_diff/86400)."d ago"; } else {
                    $res=date("y")==date("y", $time) ? date("d M", $time) : date("d M y", $time); } return $res; }
                    @endphp {{-- Check for session availablity --}} @if(!Auth::guard('vendor')->guest())
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
                            @if(!Auth::guard('vendor')->guest())
                            @include('vendor.components.left-side')

                            @elseif(!Auth::guard('user')->guest())

                            {{--Large Modal To View All Vendors--}}
                            @include('user.components.view-all')

                            {{--Left Sidebar User--}}
                            <!-- Hold User Left Sidebar For Desktop -->
                            <aside class="col-lg-3 col-md-10 side-section side-section-l" id="user-left-side">
                                <div class="justify-content-center text-center w-100 pb-2 box shadow-sm border rounded bg-white p-2"
                                    id="user-left-side-spinner" style="display: none;">
                                    <p><strong>Loading...</strong></p>
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>

                            </aside>
                            @else
                            @endif

                            <!-- Main Content -->
                            <main class="col col-md-10 col-lg-6" id="main-content">
                                @yield('content')

                                <!-- ********************** SHARED COMPONENTS ******************* -->

                                {{-- Notification Modal --}}
                                @include('components.notification-dropup')

                                {{-- Orders Modal --}}
                                @include('components.orders-dropup')

                                <!-- ********************* SHARED COMPONENTS *********************** -->


                                <!-- ********************** VENDOR COMPONENTS ******************* -->

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

                                <!-- ********************* VENDOR COMPONENTS *********************** -->



                                <!-- ********************* USER COMPONENTS ************************* -->
                                <div id="regular-order-container">

                                </div>
                                <div id="bulk-order-container">

                                </div>

                                {{-- Basket Modal --}}
                                @include('user.components.basket-dropup')

                                <!-- ********************* USER COMPONENTS ************************* -->
                            </main>

                            {{--Right Sidebar Vendor--}}
                            @if(!Auth::guard('vendor')->guest())
                            <aside
                                class="col col-lg-3 d-none d-lg-block side-section side-section-r right-side-large text-center">
                                <div class="justify-content-center text-center w-100 pb-2 box shadow-sm border rounded bg-white p-2"
                                    id="right-side-spinner" style="display: none;">
                                    <p><strong>Loading...</strong></p>
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>

                            </aside>

                            {{--Right Sidebar User--}}
                            @elseif(!Auth::guard('user')->guest())
                            <!-- Hold User Right Sidebar For Desktop -->
                            <aside class="col col-lg-3 d-none d-lg-block side-section side-section-r text-center"
                                id="user-right-side-large">
                                <div class="justify-content-center text-center w-100 pb-2 box shadow-sm border rounded bg-white p-2"
                                    id="user-right-side-spinner" style="display: none;">
                                    <p><strong>Loading...</strong></p>
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>

                            </aside>

                            <!-- Hold User Right Sidebar For Mobile -->
                            <div id="user-right-side-small">

                            </div>

                            {{--Profile Image Edit Modal--}}
                            @include('user.components.profile-image-edit')

                            <!-- Hold Profile Edit Modal For User -->
                            <div id="edit-modal-container">

                            </div>

                            @else
                            @endif

                        </div>
                    </div>

                    {{-- Location onboading --}}
                    <button class="d-none" id="launchOnboarding" data-toggle="modal" data-target="#boardModal"></button>
                    @if(!Auth::guard('vendor')->guest())

                    {{-- Floating Post Buttons --}}
                    <button class="btn btn-primary floating-post-btn d-none post-modal-init animate__animated">
                        <i class="la la-utensil-spoon la-lg"></i>
                        Post
                    </button>

                    <button
                        class="btn btn-primary floating-post-btn-sm d-none d-lg-none post-modal-init animate__animated">
                        <i class="la la-utensil-spoon la-2x"></i>
                    </button>

                    {{-- Check if vendor area is set --}}
                    @if(!Auth::user('vendor')->area)
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
                    <!-- Sweetalert -->
                    <script type="text/javascript" src="{{ url('assets/vendor/sweetalert/sweetalert.min.js') }}">
                    </script>
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
                    @if(!Auth::guard('vendor')->guest() || !Auth::guard('user')->guest())
                        @include('scripts.logged-in')

                    <!-- Socket.IO -->
                    <script src="{{ url('assets/js/socket.io/socket.io.min.js') }}"></script>
                    <script src="{{ url('assets/js/socket.client.js') }}"></script>
                    @php $logged_in = Auth::guard('vendor')->guest() ? Auth::guard('user')->user() :
                    Auth::user('vendor'); @endphp
                    <script>
                        $(document).ready(function () {
                            initIO(`{{ env('NODE_SERVER') }}`, `{{ $logged_in->username }}`, `{{ $logged_in->area_id }}`)
                        });

                    </script>
                    @else
                    <script src="{{ url('assets/js/not-logged-in.js') }}"></script>
                    @endif


                    {{-- Execute for Different Users --}}
                    @if(!Auth::guard('vendor')->guest())
                    <!-- Vendor Scipts -->
                    @include('vendor.vendor-script')
                    <script type="text/javascript" src="{{ url('assets/vendor/browser-image-compression/bic.min.js') }}"></script>
                    <!-- Vendor Scipts -->
                    @elseif(!Auth::guard('user')->guest())
                    <!-- USER SCRIPTS -->
                    @include('user.user-script')
                    <!-- USER SCRIPTS -->
                    @endif
                    <!-- Add CSRF Token to Headers for Ajax Requests -->
                    <script>
                        $(document).ready(function () {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                        });

                    </script>
                    <!-- Add CSRF Token to Headers for Ajax Requests -->
</body>

</html
