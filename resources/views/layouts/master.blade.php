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
    <script>
        $(document).ready(function () {
            // Variable to Hold Right Side Bar Active Tab
            let activeTab = '1';

            // Load The Right Side when Document is Ready
            loadRight(activeTab);
        });

        // Like/Unlike a post
        function likePost(post_id, likon) {
            // Animate Like
            $(likon).removeClass('animate__animated animate__pulse animate__faster');
            $(likon).addClass('animate__animated animate__heartBeat');

            likeCount = parseInt($(likon).attr('like-count'))

            doLike(likeCount, likon, post_id, true)

            url = `{{ url('post/like') }}/${post_id}`;

            goGet(url)
                .then(res => {
                    !res.success ? doUnlike(likeCount, likon, post_id) :
                        null
                })
                .catch(err => {
                    doUnlike(likeCount, likon, post_id)
                })
        }

        // Unlike a Post
        function unlikePost(post_id, likon) {
            // Animate Dislike
            $(likon).removeClass('animate__animated animate__heartBeat');
            $(likon).addClass('animate__animated animate__pulse animate__faster');

            likeCount = parseInt($(likon).attr('like-count'))

            doUnlike(likeCount, likon, post_id, true)

            url = `{{ url('post/unlike') }}/${post_id}`;

            goGet(url)
                .then(res => {
                    !res.success ? doLike(likeCount, likon, post_id) : null;
                })
                .catch(err => {
                    doLike(likeCount, likon, post_id)
                })
        }

        // Like
        function doLike(likeCount, likon, post_id, change = false) {
            $(likon).removeClass('la-heart-o');
            $(likon).addClass('la-heart');
            $(likon).attr('onclick', `unlikePost('${post_id}', this)`)

            if (change) {
                likeCount += 1
            }

            $(likon).attr('like-count', likeCount)
            $($(likon).siblings()[0]).text(' ' + likeCount)
        }

        // Unlike
        function doUnlike(likeCount, likon, post_id, change = false) {
            $(likon).removeClass('la-heart');
            $(likon).addClass('la-heart-o');
            $(likon).attr('onclick', `likePost('${post_id}', this)`);

            if (change) {
                likeCount = likeCount == 0 ? 0 : likeCount - 1
            }

            $(likon).attr('like-count', likeCount)
            $($(likon).siblings()[0]).text(' ' + likeCount)
        }

        // Load Right Side (Vendor Dish & Menu)
        function loadRight(activeTab) {
            spin('right-side')
            // Populate dishes tab on page load
            let getUrl = "{{url('vendor/dish')}}";

            goGet(getUrl).then((res) => {
                spin('right-side')
                if (window.matchMedia("(max-width: 767px)").matches) {
                    // The viewport is less than 768 pixels wide (mobile device)
                    $("#dish-menu").remove();
                    $(".right-side-large").empty();
                    $(".right-side-small").append(res);
                    $(`#rightTab li:nth-child(${activeTab}) a`).tab('show');
                } else {
                    // The viewport is at least 768 pixels wide (Desktop or tablet)
                    $("#dish-menu").remove();
                    $(".right-side-small").empty();
                    $(".right-side-large").append(res);
                    $(`#rightTab li:nth-child(${activeTab}) a`).tab('show');
                }
            }).catch((err) => {
                spin('right-side')
            });
        }

        // Load Menu Modal Data
        function loadMenuModal() {
            let getUrl = "{{url('vendor/menu')}}";
            goGet(getUrl).then((res) => {
                $("#menu-modal-holder").empty();
                $("#menu-modal-holder").html(res);
                $("#menu-update-modal").modal('show');
            }).catch((err) => {
                console.error(err);
            });
        }

        // Function Keeps Track of Active Tab
        function track(active = '1') {
            activeTab = active;
        }

    </script>
    @else
    <script>
        function likePost(post_id, likon) {
            $('#login-btn-top').click();
        }

    </script>
    @endif
</body>

</html
