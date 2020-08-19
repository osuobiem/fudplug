<!-- Mobile Bottom Menu -->
<div class="mobile-bottom d-lg-none">

    <div class="page-loader animate__animated animate__fadeIn" style="display:none">
        <div class="col-12 loader-cont d-block d-lg-none">
            <div class="loader">
                <div class="loaderBar"></div>
            </div>
        </div>
    </div>

    <nav class="navbar-bottom navbar-expand navbar-light bg-light osahan-nav-top h-80" id="b-m">
        <div class="container row m-0 text-center px-0">
            <div class="col-3" onclick="loadPage('feed', 'feed')">
                <i class="la la-utensils la-2x p-2 mbm-item mbm-active" id="feed-i"></i>
            </div>
            <div class="col-3" onclick="loadPage('vendor/notifications', 'notifications')">
                <i class="la la-bell la-2x feather-24 p-2 mbm-item" id="notifications-i"></i>
            </div>
            <div class="col-3" onclick="loadPage('vendor/orders', 'orders')">
                <i class="la la-list la-2x p-2 mbm-item" id="orders-i"></i>
            </div>
            <div class="col-3" onclick="loadPage('vendor/profile', 'profile')">
                <i class="la la-user la-2x p-2 mbm-item" id="profile-i"></i>
            </div>
        </div>
    </nav>
</div>