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

		<div class="bg-white text-center d-none" id="send-post-liner-lg" style="margin: 0 11.3px;">
			<strong style="font-size: 10px;">Sending your post ...</strong>
			<div class="ploader border rounded">
				<div class="bar"></div>
			</div>
		</div>

	</div>
	<div class="col-3 col-md-4 col-lg-3 p-0">
		<nav class="navbar navbar-expand navbar-light bg-light osahan-nav-top h-80 p-1" id="rt-h">
			<div class="container justify-content-center">
				<ul class="navbar-nav ml-auto d-flex align-items-center">

					<!-- Nav Item - User Information -->

					<li class="nav-item dropdown no-arrow ml-1 osahan-profile-dropdown pr-3 d-none d-lg-flex"
						title="Notifications">
						<a class="nav-link dropdown-toggle pr-0 h-link" href="#" role="button" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
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
					</li>

					<li class="nav-item dropdown no-arrow ml-1 osahan-profile-dropdown">
						<a class="nav-link dropdown-toggle pr-0 u-link" href="#" role="button" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							<p class="m-auto d-none d-md-block bright-ic" style="font-size: medium;">
								{{ Auth::user('vendor')->business_name }}
							</p>
							&nbsp; &nbsp;
							<img class="img-profile rounded-circle"
								src="{{ Storage::url('vendor/profile/'.Auth::user('vendor')->profile_image) }}">
							<i class="feather-chevron-down"></i>
						</a>
						<!-- Dropdown - User Information -->
						<div class="dropdown-menu dropdown-menu-right shadow">
							<a class="dropdown-item" href="{{ url(Auth::user()->username) }}"><i
									class="la la-store-alt la-lg mr-1"></i>
								Profile</a>
							<a class="dropdown-item" href="{{ url('vendor/logout') }}"><i
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

<!-- Notification pagination holder -->
<span class="d-none" id="noti-from">0</span>
@php $other_details = json_decode(Auth::user('vendor')->other_details, true); @endphp
@if(isset($other_details['nviewed']) && $other_details['nviewed'] > 0)
	@push('scripts')
		<script>
			$('#noti-dot').text(`{{ $other_details['nviewed'] }}`)
			$('#noti-dot').removeClass('d-none');
			$('#mob-noti-dot').text(`{{ $other_details['nviewed'] }}`)
			$('#mob-noti-dot').removeClass('d-none');
		</script>
	@endpush
@endif

@include('vendor.components.mobile-bottom-menu')
