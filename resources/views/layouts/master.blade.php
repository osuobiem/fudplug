<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>fudplug</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <link rel="stylesheet" type="text/css" href="{{ url('assets/css/animate.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('assets/css/line-awesome.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('assets/css/line-awesome-font-awesome.min.css') }}">
  <link href="{{ url('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="{{ url('assets/css/font-awesome.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('assets/css/jquery.mCustomScrollbar.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('assets/lib/slick/slick.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('assets/lib/slick/slick-theme.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('assets/css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('assets/css/responsive.css') }}">
</head>

<body oncontextmenu="return false;">

  <div class="wrapper">
    <header>
      <div class="container">
        <div class="header-data">
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
								<a href="#" title=""  class="not-box-open">
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
              <h3>Online Status</h3>
              <ul class="on-off-status">
                <li>
                  <div class="fgt-sec">
                    <input type="radio" name="cc" id="c5">
                    <label for="c5">
                      <span></span>
                    </label>
                    <small>Online</small>
                  </div>
                </li>
                <li>
                  <div class="fgt-sec">
                    <input type="radio" name="cc" id="c6">
                    <label for="c6">
                      <span></span>
                    </label>
                    <small>Offline</small>
                  </div>
                </li>
              </ul>
              <h3>Custom Status</h3>
              <div class="search_form">
                <form>
                  <input type="text" name="search">
                  <button type="submit">Ok</button>
                </form>
              </div>
              <!--search_form end-->
              <h3>Setting</h3>
              <ul class="us-links">
                <li><a href="profile-account-setting.html" title="">Account Setting</a></li>
                <li><a href="#" title="">Privacy</a></li>
                <li><a href="#" title="">Faqs</a></li>
                <li><a href="#" title="">Terms & Conditions</a></li>
              </ul>
              <h3 class="tc"><a href="sign-in.html" title="">Logout</a></h3>
            </div>
            <!--user-account-settingss end-->
          </div>
        </div>
        <!--header-data end-->
      </div>
    </header>
  </div>

  {{-- Scripts --}}
  <script type="text/javascript" src="{{ url('assets/js/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('assets/js/popper.js') }}"></script>
  <script type="text/javascript" src="{{ url('assets/js/bootstrap.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('assets/js/jquery.mCustomScrollbar.js') }}"></script>
  <script type="text/javascript" src="{{ url('assets/lib/slick/slick.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('assets/js/scrollbar.js') }}"></script>
  <script type="text/javascript" src="{{ url('assets/js/script.js') }}"></script>
</body>

</html>