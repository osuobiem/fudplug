<!-- Header -->
<div class="row m-0 head-section">
	<div class="col-3 col-md-4 col-lg-3 p-0">
		<nav class="navbar navbar-expand navbar-light bg-light osahan-nav-top p-1 h-80" id="lt-h">
			<div class="container">
				<a class="navbar-brand mr-2" href="index.html"><img id="logo" src="{{ url('assets/img/logo.svg') }}" alt="">
				</a>
			</div>
		</nav>
	</div>
	<div class="col-6 col-md-4 col-lg-6 p-0">
		<nav class="navbar navbar-expand navbar-light bg-light osahan-nav-top p-1 h-80 justify-content-center" id="mt-h">
			<form class="form-inline mr-auto my-2 my-md-0 mw-100">
				<div class="input-group">
					<input type="text" class="form-control " placeholder="Search fudplug" aria-label="Search"
						aria-describedby="basic-addon2">
					<div class="input-group-append">
						<button class="btn btn-primary hover-lift" type="button">
							<i class="la la-search la-lg"></i>
						</button>
					</div>
				</div>
			</form>
		</nav>
	</div>
	<div class="col-3 col-md-4 col-lg-3 p-0">
		<nav class="navbar navbar-expand navbar-light bg-light osahan-nav-top h-80 p-1" id="rt-h">
			<div class="container justify-content-center">
				<ul class="navbar-nav ml-auto d-flex align-items-center">

					<!-- Nav Item - User Information -->
					@if(Auth::guard('vendor')->guest())
					<li class="nav-item nav-link ml-1 p-0">
						<a class="btn btn-primary text-light hover-lift" id="login-btn-top" href="#loginModal" data-toggle="modal">
							<strong>
								<i class="la la-sign-in d-none d-sm-inline"></i> Login
							</strong>
						</a>
					</li>
					@else
					<li class="nav-item dropdown no-arrow ml-1 osahan-profile-dropdown pr-3 d-none d-lg-flex">
						<a class="nav-link dropdown-toggle pr-0 h-link" href="#" role="button" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							<span class="noti-pin d-none"></span>
							<i class="feather-bell feather-18 icon-hover bright-ic"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right shadow noti-drop">
							<h6 class="dropdown-header text-center">
								Notifications
							</h6>
							<div class="dropdown-divider"></div>
							<div id="h-noti-cont" class="p-2 text-center">
								<p>No Notifications yet!</p>
							</div>
						</div>
					</li>

					<li class="nav-item dropdown no-arrow ml-1 osahan-profile-dropdown">
						<a class="nav-link dropdown-toggle pr-0 u-link" href="#" role="button" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							<p class="m-auto d-none d-md-block bright-ic" style="font-size: medium;">
								John Doe
							</p>
							&nbsp; &nbsp;
							<img class="img-profile rounded-circle" src="#">
							<i class="feather-chevron-down"></i>
						</a>
						<!-- Dropdown - User Information -->
						<div class="dropdown-menu dropdown-menu-right shadow">
							<a class="dropdown-item" href="#"><i class="feather-user mr-1"></i> Profile</a>
							<a class="dropdown-item" href="#"><i class="feather-settings mr-1"></i> Settings</a>
							<a class="dropdown-item" href="#"><i class="feather-log-out mr-1"></i>
								Logout</a>
							<div class="dropdown-divider"></div>
						</div>
					</li>
					@endif
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