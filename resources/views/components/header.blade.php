<header>
	<div class="container">
		<div class="header-data d-flex">
			<div class="logo">
				<a href="index.html" title=""><img src="{{ url('assets/images/logo.png') }}" alt=""></a>
			</div>
			<!--logo end-->

			<div class="search-bar">
				<form>
					<input type="text" name="search" placeholder="Search...">
					<button type="submit"><i class="la la-search"></i></button>
				</form>
			</div>
			<!--search-bar end-->

			<nav>
				<ul>
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
								{{-- <div class="notfication-details">
                      <div class="noty-user-img">
                        <img src="{{ url('assets/images/resources/ny-img2.png') }}" alt="">
							</div>
							<div class="notification-info">
								<h3><a href="#" title="">Jassica William</a> Comment on your project.</h3>
								<span>2 min ago</span>
							</div>
							<!--notification-info -->
						</div> --}}
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
				{{-- <div class="notfication-details">
                      <div class="noty-user-img">
                        <img src="{{ url('assets/images/resources/ny-img2.png') }}" alt="">
			</div>
			<div class="notification-info">
				<h3><a href="#" title="">Jassica William</a> Comment on your project.</h3>
				<span>2 min ago</span>
			</div>
			<!--notification-info -->
		</div> --}}
		<div class="view-all-nots">
			<a href="#" title="">View All Orders</a>
		</div>
		</div>
		<!--nott-list end-->
		</div>
	</li>
	</ul>
	</nav>
	<!--nav end-->

	<div class="user-account">
		<div class="user-info">
			<img src="{{ url('assets/images/resources/user.png') }}" alt="">
			<a href="#" title="">John</a>
			<i class="la la-sort-down"></i>
		</div>
		<div class="user-account-settingss" id="users">
			<h3>John Doe</h3>
			<ul class="us-links">
				<li><a href="profile-account-setting.html" title="">
						<i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;My Account</a></li>
			</ul>
			<h3 class="tc"><a href="#" title="">Logout</a></h3>
		</div>
		<!-- <button class="btn btn-light mt-2">Login</button> -->
		<!--user-account-settings end-->
	</div>
	</div>
	<!--header-data end-->
	</div>
</header>