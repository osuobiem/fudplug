{{-- Format Time/Date --}}
@php
function format_time($time) {
$time = strtotime($time);
$t_diff = time() - $time;
$res = "";

if($t_diff < 60) {
    $res = $t_diff < 1 ? 'now' : $t_diff."s ago";
}
elseif($t_diff >= 60 && $t_diff < 3600) {
    $res = (int)($t_diff/60)."m ago";
}
elseif($t_diff >= 3600 && $t_diff < 86399) {
    $res = (int)($t_diff/3600)."h ago";
}
elseif($t_diff >= 86400 && $t_diff < 604799) {
    $res = (int)($t_diff/86400)."d ago";
}
else {
    $res = date("y") == date("y", $time) ? date("d M", $time) : date("d M y", $time);
}

return $res;
}
@endphp

@if(count($notifications) > 0)
    @foreach ($notifications as $notification)
        <div class="notification-card-{{ $notification->status == 0 ? 'u' : 'r' }} row">
            <div class="col-1 p-0 pt-1">
                <div class="comments-img"
                    style="background-image: url('{{ $notification->photo }}')">
                </div>
            </div>
            <div class="{{ $notification->status == 0 ? 'col-10' : 'col-11' }}">
                {!! html_entity_decode($notification->content) !!}
            </div>
            @if($notification->status == 0)
            <div class="col-1">
                <i class="la la-check icon-hover bright-ic ml-2 p-0 m-a-r" onclick="markAsRead('{{ $notification->id }}', this)" title="Mark as read">
                </i>
            </div>
            <script>
                $('.m-a-a-r').removeClass('d-none')
            </script>
            @endif
            <div class="col-12 p-0 text-right">
                <small style="font-size: 10px;">{{ format_time($notification->created_at) }}</small>
            </div>
        </div>
    @endforeach

    <script>
        $('#noti-from').text('{{ $from }}')
    </script>
@else
    <div class="h-noti-cont p-2 text-center">
        <p>No Notifications yet!</p>
    </div>
@endif