<header>
	<div class="container-fluid">
		<!-- Mobile Header -->
		<div class="header-data d-block d-sm-none">
			<div class="logo m-0 my-2">
				<a href="index.html" title=""><img src="{{ url('assets/images/logo.png') }}" alt="" /></a>
			</div>
		</div>

		<!-- Desktop Header -->
		<div class="header-data d-none d-sm-flex d-lg-block">
			<div class="logo">
				<a href="index.html" title=""><img src="{{ url('assets/images/logo.png') }}" alt="" /></a>
			</div>
			<!--logo end-->

			<div class="search-bar">
				<form>
					<input type="text" name="search" placeholder="Search..." />
					<button type="submit"><i class="la la-search"></i></button>
				</form>
			</div>
			<!--search-bar end-->

			<nav>
				<ul>
					@if(!Auth::guest())
					<li>
						<a href="#" title="" class="not-box-open">
							<span><i class="la la-bell la-lg"></i></span>
							Notifications
						</a>
						<div class="notification-box noti" id="notification">
							<div class="nt-title">
								<h4>Notifications</h4>
								<a href="#" title="">Mark all as read</a>
							</div>
							<div class="nott-list">
								<div class="notfication-details">
									<p>No notifications yet!</p>
									<!--notification-info -->
								</div>
								<div class="view-all-nots">
									<a href="#" title="">View All Notifications</a>
								</div>
							</div>
							<!--nott-list end-->
						</div>
						<!--notification-box end-->
					</li>

					<li>
						<a href="#" title="" class="not-box-open">
							<span><i class="la la-list la-lg"></i></span>
							Orders
						</a>
						<div class="notification-box noti" id="notification">
							<div class="nt-title">
								<h4>Orders</h4>
							</div>
							<div class="nott-list">
								<div class="notfication-details">
									<p>No orders yet!</p>
									<!--notification-info -->
								</div>
								<div class="view-all-nots">
									<a href="#" title="">View All Orders</a>
								</div>
							</div>
							<!--nott-list end-->
						</div>
					</li>
					@endif
				</ul>
			</nav>
			<!--nav end-->


			<div class="user-account">
				@if(Auth::guest())
				<button class="btn btn-light my-2" style="float: right;" id="login-btn">Login</button>
				@else
				<div class="user-info">
					<img src="{{ url('assets/images/resources/user.png') }}" alt="" />
					<a href="#" class="d-none d-lg-block">John</a>
					<i class="la la-sort-down"></i>
				</div>
				<div class="user-account-settingss" id="users">
					<h3>John Doe</h3>
					<ul class="us-links">
						<li>
							<a href="profile-account-setting.html" title="">
								<i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;My
								Account</a>
						</li>
					</ul>
					<h3 class="tc"><a href="#" title="">Logout</a></h3>
				</div>
				<!--user-account-settings end-->
			</div>
			@endif
		</div>

	</div>
</header>

<!-- Mobile Bottom Menu -->
<div class="header-data d-flex d-sm-none mobile-bottom">
	<div class="logo m-0 row">
		<div class="col-3">
			<i class="la la-home la-2x p-2 mbm-active"></i>
		</div>
		<div class="col-3">
			<i class="la la-list la-2x p-2 "></i>
		</div>
		<div class="col-3">
			<i class="la la-search la-2x p-2"></i>
		</div>
		<div class="col-3">
			<i class="la la-user la-2x p-2"></i>
		</div>
	</div>
</div>