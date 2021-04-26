@if(isset(Auth::guard('vendor')->user()->area_id))
    <!-- Mobile Bottom Menu -->
    <div class="mobile-bottom d-lg-none">

        <div class="bg-white text-center pt-1 d-none" id="send-post-liner-sm" style="border-top: solid .5px #ced4da">
            <div class="ploader border rounded">
                <div class="bar"></div>
            </div>
            <strong style="font-size: 10px;">Sending your post ...</strong>
        </div>

        <nav class="navbar-bottom navbar-expand navbar-light bg-light osahan-nav-top h-80" id="b-m">
            <div class="container row m-0 text-center px-0">
                <div class="col-3">
                    <i class="la la-utensils la-2x p-2 mbm-item {{ Request::is('/') ? 'mbm-active' : '' }}"
                        onclick="gotoP(`{{ url('/') }}`)"></i>
                </div>
                <div class="col-3">
                    <span onclick="openMND()">
                        <i class="la la-bell la-2x feather-24 p-2 mbm-item"></i>
                        <small id="mob-noti-dot" class="d-none">0</small>
                    </span>
                </div>
                <div class="col-3">
                    <i class="la la-list la-2x p-2 mbm-item" onclick="openOrders()"></i>
                </div>
                <div class="col-3">
                    <i class="la la-user la-2x p-2 mbm-item {{ Request::is(Auth::user()->username) ? 'mbm-active' : '' }}"
                        onclick="gotoP(`{{ url(Auth::user()->username) }}`)"></i>
                </div>
            </div>
        </nav>
    </div>
@endif
