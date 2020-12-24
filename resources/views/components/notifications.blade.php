@if($notifications as $notification)
    @if($notification->status == 0)
        <div class="notification-card-u row">
            <div class="col-1 p-0 pt-1">
                <div class="comments-img"
                    style="background-image: url('{{ Storage::url('vendor/profile/'.Auth::user('vendor')->profile_image) }}')">
                </div>
            </div>
            <div class="col-10">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            </div>
            <div class="col-1">
                <i class="la la-check icon-hover bright-ic ml-2 p-0" title="Mark as read">
                </i>
            </div>
            <div class="col-12 p-0 text-right">
                <small style="font-size: 10px;">7 hours ago</small>
            </div>
        </div>
    @else
        <div class="notification-card-r row">
            <div class="col-1 p-0 pt-1">
                <div class="comments-img"
                    style="background-image: url('{{ Storage::url('vendor/profile/'.Auth::user('vendor')->profile_image) }}')">
                </div>
            </div>
            <div class="col-11">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            </div>
            <div class="col-12 p-0 text-right">
                <small style="font-size: 10px;">7 hours ago</small>
            </div>
        </div>
    @endif
@else
    <div id="h-noti-cont" class="p-2 text-center">
        <p>No Notifications yet!</p>
    </div>
@endif