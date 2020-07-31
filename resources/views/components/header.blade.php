{{-- Mobile Header --}}
<div class="responsive-header">
	<div class="mh-head second py-4">
	</div>
</div>

{{-- Desktop Header --}}
<div class="topbar transparent stick">
	<div class="logo">
		<a title="" href="newsfeed.html"><img src="{{ url('assets/images/logo.png') }}" alt=""></a>
	</div>
	<div class="top-area">
		<div class="top-search">
			<form method="post" class="">
				<input type="text" placeholder="Search People, Pages, Groups etc">
				<button data-ripple><i class="ti-search"></i></button>
			</form>
		</div>

		{{-- Guest Check --}}

		@if(Auth::guest())
		<div class="h-pos-btn">
			<a class="main-btn2" href="#login-modal" data-toggle="modal" title="">
				{{ !isset($_COOKIE['new']) ? 'Join' : 'Login' }}
			</a>
		</div>

		@else

		<ul class="setting-area">
			<li><a href="newsfeed.html" title="Home" data-ripple=""><i class="fa fa-home"></i></a></li>
			<li>
				<a href="#" title="Notification" data-ripple="">
					<i class="fa fa-bell"></i>
				</a>
				<div class="dropdowns">
					<span>4 New Notifications <a href="#" title="">Mark all as read</a></span>
					<ul class="drops-menu">
						<li>
							<a href="notifications.html" title="">
								<figure>
									<img src="images/resources/thumb-1.jpg" alt="">
									<span class="status f-online"></span>
								</figure>
								<div class="mesg-meta">
									<h6>sarah Loren</h6>
									<span>commented on your new profile status</span>
									<i>2 min ago</i>
								</div>
							</a>
						</li>
						<li>
							<a href="notifications.html" title="">
								<figure>
									<img src="images/resources/thumb-2.jpg" alt="">
									<span class="status f-online"></span>
								</figure>
								<div class="mesg-meta">
									<h6>Jhon doe</h6>
									<span>Nicholas Grissom just became friends. Write on his wall.</span>
									<i>4 hours ago</i>
									<figure>
										<span>Today is Marina Valentine’s Birthday! wish for celebrating</span>
										<img src="images/birthday.png" alt="">
									</figure>
								</div>
							</a>
						</li>
						<li>
							<a href="notifications.html" title="">
								<figure>
									<img src="images/resources/thumb-3.jpg" alt="">
									<span class="status f-online"></span>
								</figure>
								<div class="mesg-meta">
									<h6>Andrew</h6>
									<span>commented on your photo.</span>
									<i>Sunday</i>
									<figure>
										<span>"Celebrity looks Beautiful in that outfit! We should see each"</span>
										<img src="images/resources/admin.jpg" alt="">
									</figure>
								</div>
							</a>
						</li>
						<li>
							<a href="notifications.html" title="">
								<figure>
									<img src="images/resources/thumb-4.jpg" alt="">
									<span class="status f-online"></span>
								</figure>
								<div class="mesg-meta">
									<h6>Tom cruse</h6>
									<span>nvited you to attend to his event Goo in</span>
									<i>May 19</i>
								</div>
							</a>
							<span class="tag">New</span>
						</li>
						<li>
							<a href="notifications.html" title="">
								<figure>
									<img src="images/resources/thumb-5.jpg" alt="">
									<span class="status f-online"></span>
								</figure>
								<div class="mesg-meta">
									<h6>Amy</h6>
									<span>Andrew Changed his profile picture. </span>
									<i>dec 18</i>
								</div>
							</a>
							<span class="tag">New</span>
						</li>
					</ul>
					<a href="notifications.html" title="" class="more-mesg">View All</a>
				</div>
			</li>
			<li>
				<a href="#" title="Orders" data-ripple=""><i class="fa fa-list"></i><em class="bg-red">9</em></a>
				<div class="dropdowns">
					<span>5 New Messages <a href="#" title="">Mark all as read</a></span>
					<ul class="drops-menu">
						<li>
							<a class="show-mesg" href="#" title="">
								<figure>
									<img src="images/resources/thumb-1.jpg" alt="">
									<span class="status f-online"></span>
								</figure>
								<div class="mesg-meta">
									<h6>sarah Loren</h6>
									<span><i class="ti-check"></i> Hi, how r u dear ...?</span>
									<i>2 min ago</i>
								</div>
							</a>
						</li>
						<li>
							<a class="show-mesg" href="#" title="">
								<figure>
									<img src="images/resources/thumb-2.jpg" alt="">
									<span class="status f-offline"></span>
								</figure>
								<div class="mesg-meta">
									<h6>Jhon doe</h6>
									<span><i class="ti-check"></i> We’ll have to check that at the office and see if the client is on
										board with</span>
									<i>2 min ago</i>
								</div>
							</a>
						</li>
						<li>
							<a class="show-mesg" href="#" title="">
								<figure>
									<img src="images/resources/thumb-3.jpg" alt="">
									<span class="status f-online"></span>
								</figure>
								<div class="mesg-meta">
									<h6>Andrew</h6>
									<span> <i class="fa fa-paperclip"></i>Hi Jack's! It’s Diana, I just wanted to let you know that we
										have to reschedule..</span>
									<i>2 min ago</i>
								</div>
							</a>
						</li>
						<li>
							<a class="show-mesg" href="#" title="">
								<figure>
									<img src="images/resources/thumb-4.jpg" alt="">
									<span class="status f-offline"></span>
								</figure>
								<div class="mesg-meta">
									<h6>Tom cruse</h6>
									<span><i class="ti-check"></i> Great, I’ll see you tomorrow!.</span>
									<i>2 min ago</i>
								</div>
							</a>
							<span class="tag">New</span>
						</li>
						<li>
							<a class="show-mesg" href="#" title="">
								<figure>
									<img src="images/resources/thumb-5.jpg" alt="">
									<span class="status f-away"></span>
								</figure>
								<div class="mesg-meta">
									<h6>Amy</h6>
									<span><i class="fa fa-paperclip"></i> Sed ut perspiciatis unde omnis iste natus error sit </span>
									<i>2 min ago</i>
								</div>
							</a>
							<span class="tag">New</span>
						</li>
					</ul>
					<a href="chat-messenger.html" title="" class="more-mesg">View All</a>
				</div>
			</li>
		</ul>
		<div class="user-img">
			<h5>Jack Carter</h5>
			<img src="{{ url('assets/images/resources/admin.jpg') }}" alt="">
			<span class="fa fa-angle-down text-light"></span>
			<div class="user-setting">
				<span class="seting-title">Chat setting <a href="#" title="">see all</a></span>
				<ul class="chat-setting">
					<li><a href="#" title=""><span class="status f-online"></span>online</a></li>
					<li><a href="#" title=""><span class="status f-away"></span>away</a></li>
					<li><a href="#" title=""><span class="status f-off"></span>offline</a></li>
				</ul>
				<span class="seting-title">User setting <a href="#" title="">see all</a></span>
				<ul class="log-out">
					<li><a href="about.html" title=""><i class="ti-user"></i> view profile</a></li>
					<li><a href="setting.html" title=""><i class="ti-pencil-alt"></i>edit profile</a></li>
					<li><a href="#" title=""><i class="ti-target"></i>activity log</a></li>
					<li><a href="setting.html" title=""><i class="ti-settings"></i>account setting</a></li>
					<li><a href="logout.html" title=""><i class="ti-power-off"></i>log out</a></li>
				</ul>
			</div>
		</div>
		@endif
	</div>
</div>