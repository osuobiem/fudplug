<!-- Mobile Bottom Menu -->
    <div class="mobile-bottom d-lg-none">
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
                <div class="col-3" id="mob-order-btn">
                    <i class="la la-list la-2x p-2" onclick="openOrders()"></i>
                </div>
                <div class="col-3" id="mob-basket-btn">
                    <i class="la la-shopping-basket la-2x p-2"  onclick="openBasket()"></i>
                    <small id="mob-basket-noti-dot" class="d-none">0</small>
                </div>
            </div>
        </nav>
    </div>
