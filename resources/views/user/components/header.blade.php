<!-- Header -->
<div class="row m-0 head-section">
    <div class="col-8 col-md-4 col-lg-3 p-0">
        <nav class="navbar navbar-expand navbar-light bg-light osahan-nav-top p-1 h-80" id="lt-h">
            <div class="container">
                <a class="navbar-brand mr-2" href="{{ url('') }}"><img id="logo" src="{{ url('assets/img/logo.png') }}"
                        alt="">
                </a>
            </div>
        </nav>
    </div>
    <div class="col-1 col-md-4 col-lg-6 p-0">
        <nav class="navbar navbar-expand navbar-light bg-light osahan-nav-top p-1 h-80 justify-content-center"
            id="mt-h">
            <!-- <form class="form-inline mr-auto my-2 my-md-0 mw-100">
				<div class="input-group">
					<input type="text" class="form-control " placeholder="Search fudplug" aria-label="Search"
						aria-describedby="basic-addon2">
					<div class="input-group-append">
						<button class="btn btn-primary hover-lift" type="button">
							<i class="la la-search la-lg"></i>
						</button>
					</div>
				</div>
			</form> -->
        </nav>
    </div>
    <div class="col-3 col-md-4 col-lg-3 p-0">
        <nav class="navbar navbar-expand navbar-light bg-light osahan-nav-top h-80 p-1" id="rt-h">
            <div class="container justify-content-center">
                <ul class="navbar-nav ml-auto d-flex align-items-center">

                    <!-- Nav Item - User Information -->

                    <!-- <li class="nav-item dropdown no-arrow ml-1 osahan-profile-dropdown pr-3 d-none d-lg-flex"
						title="Notifications">
						<a class="nav-link dropdown-toggle pr-0 h-link" href="#" role="button" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							<span class="noti-pin d-none"></span>
							<i class="la la-bell la-2x icon-hover bright-ic" onclick="clearNViewed()"></i>
							<small id="noti-dot" class="d-none">0</small>
						</a>
						<div class="dropdown-menu dropdown-menu-right shadow noti-drop">
							<h6 class="dropdown-header text-center">
								Notifications
							</h6>
							<div id="m-a-a-r" class="text-center d-none" title="Mark all as read">
								<small onclick="markAllAsRead()">Mark all as read</small>
							</div>
							<div class="dropdown-divider"></div>

							<div id="notification-container" onscroll="getMoreNotifications()">
								<div class="justify-content-center text-center w-100 p-2">
									<div class="spinner-border spinner-border-sm btn-pr p-2" role="status">
									  <span class="sr-only">Loading...</span>
									</div>
								  </div>
							</div>

						</div>
					</li> -->

                    <li class="nav-item dropdown no-arrow ml-1 osahan-profile-dropdown pr-3 d-none d-lg-flex"
                        title="Notifications" id="basket-dropdown">
                        <a class="nav-link dropdown-toggle pr-0 h-link" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <span class="basket-noti-pin d-none"></span>
                            <i class="las la-shopping-basket la-2x icon-hover bright-ic"></i>
                            <small id="basket-noti-dot" class="d-none">0</small>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow noti-drop">
                            <h6 class="dropdown-header text-center head-count">
                                My Basket <span id="head-count"></span>
                            </h6>
                            <div class="dropdown-divider"></div>
                            <div class="box-body text-center job-item-2">
                                <div class="col-12 generic-scrollbar basket-container"
                                    style="max-height: 450px; overflow: auto;">

                                    <div class="spinner-border spinner-border-sm btn-pr" role="status"
                                        style="display: none;" id="basket-container-spinner">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div class="col-12 pt-2">
                                    <button type="button" onclick="placeOrder()"
                                        class="btn btn-sm btn-primary btn-block font-weight-bold basket-order-btn"
                                        data-attach-loading="true" disabled>

                                        <span id="basket-txt">Place order</span>
                                        <div class="spinner-border spinner-border-sm btn-pr" id="basket-spinner"
                                            style="display: none;" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <span class="float-right basket-final-price" data-item-subtotal="">₦0.00</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown no-arrow ml-1 osahan-profile-dropdown pr-3 d-none d-lg-flex"
                        title="Notifications">
                        <a class="nav-link dropdown-toggle pr-0 h-link" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <span class="noti-pin d-none"></span>
                            <i class="la la-bell la-2x icon-hover bright-ic"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow noti-drop">
                            <h6 class="dropdown-header text-center">
                                Notifications
                            </h6>
                            <div class="dropdown-divider"></div>
                            <div class="h-noti-cont p-2 text-center">
                                <p>No Notifications yet!</p>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown no-arrow ml-1 osahan-profile-dropdown pr-3 d-none d-lg-flex"
                        title="Orders">
                        <a class="nav-link dropdown-toggle pr-0 h-link" href="#" id="order-btn" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="noti-pin d-none"></span>
                            <i class="la la-list la-2x icon-hover bright-ic"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow noti-drop">
                            <h6 class="dropdown-header text-center">
                                <span>
                                    My Orders <span id="state-display">(Today)</span>
                                </span>
                                <span class="float-right">
                                    <a href="javascript:void(0)" title="Order history" class="text-dark"
                                        id="order-history-btn"><i class="las la-history la-2x"></i></a>
                                    <a href="javascript:void(0)" title="Today's Orders" class="text-dark d-none"
                                        id="today-order-btn"><i class="las la-list la-2x"></i></a>
                                </span>
                            </h6>
                            <div class="dropdown-divider"></div>
                            <div class="box-body generic-scrollbar p-2 text-center job-item-2 desktop-order-container"
                                style="max-height: 100px; overflow: auto;" id="h-noti-cont">

                                <div class="spinner-border spinner-border-sm btn-pr" role="status"
                                    style="display: none;" id="order-container-spinner">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12 mt-xs-2">
                                    <button type="button" id="order-cancel-btn"
                                        class="btn btn-sm btn-primary btn-block font-weight-bold"
                                        data-attach-loading="true">
                                        <span id="order-cancel-txt">
                                            <i class="las la-times"></i>&nbsp;Cancel All
                                        </span>
                                        <div class="spinner-border spinner-border-sm btn-pr" id="order-cancel-spinner"
                                            style="display: none;" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <span id="order-price" class="float-right" data-item-subtotal="">₦0.00</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown no-arrow ml-1 osahan-profile-dropdown">
                        <a class="nav-link dropdown-toggle pr-0 u-link" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <p class="m-auto d-none d-md-block bright-ic" style="font-size: medium;">
                                {{ strlen(Auth::guard('user')->user()->business_name) > 20 ? substr(Auth::guard('user')->user()->business_name, 0, 15).'...' : Auth::guard('user')->user()->business_name }}
                            </p>
                            &nbsp; &nbsp;
                            <img class="img-profile rounded-circle"
                                src="{{ Storage::url('user/profile/'.Auth::guard('user')->user()->profile_image) }}">
                            <i class="feather-chevron-down"></i>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow">
                            <a class="dropdown-item d-lg-none" id="user-profile-btn"><i
                                    class="la la-user la-lg mr-1"></i> Profile</a>
                            <a class="dropdown-item" href="{{ url('user/logout') }}"><i
                                    class="la la-sign-out la-lg mr-1"></i>
                                Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<!-- Alert Error -->
<div class="alert alert-danger fud-alert animate__animated animate__lightSpeedInRight d-none" id="alert-error"
    role="alert">
</div>

<!-- Alert Success -->
<div class="alert alert-success text-center fud-alert animate__animated animate__fadeIn d-none" role="alert"
    id="alert-success">
</div>

@include('user.components.mobile-bottom-menu')
