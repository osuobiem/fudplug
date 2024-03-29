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

    <div class="col-1 p-0 pt-1">
        <div class="comments-img"
            style="background-image: url('{{ $notification->photo }}')">
        </div>
    </div>
    <div class="col-11">
        {!! html_entity_decode($notification->content) !!}
    </div>
    <div class="col-12 p-0 text-right">
        <small style="font-size: 10px;">{{ format_time($notification->created_at) }}</small>
    </div>