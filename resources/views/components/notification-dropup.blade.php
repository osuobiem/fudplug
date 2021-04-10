<div class="dropup-container mnd-container animate__animated d-none">
    <div class="dropup-inner mnd-inner animate__animated" style="height: 90%">
  
      <ul class="nav nav-justified osahan-line-tab" style="box-shadow: 0 5px 10px 0 #00000061">
        <li class="nav-item text-left">
          <a class="nav-link active dropup-top-a d-flex" style="padding: 0 !important">
            <span class="ml-2 py-2"> <i class="la la-bell la-lg"></i> Notifications</span>
            <div class="text-right">
              <i class="la la-times la-lg dropup-top-ico" onclick="closeMND()"></i>
            </div>
          </a>
        </li>
      </ul>
  
      <div class="text-center m-a-a-r mt-3 d-none" title="Mark all as read">
        <small onclick="markAllAsRead()">Mark all as read</small>
      </div>
      <div class="dropdown-divider mb-0"></div>
      
      <div class="notification-cont-gen pb-2" id="mob-notification-holder" onscroll="getMoreNotifications()">
        <div class="justify-content-center text-center w-100 p-2">
          <div class="spinner-border spinner-border-sm btn-pr p-2" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>