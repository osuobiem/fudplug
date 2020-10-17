{{-- Format Time/Date --}}
@php
function ftime($time) {
  $time = strtotime($time);
  $t_diff = time() - $time;
  $res = "";

  if($t_diff < 60) {
    $res = $t_diff == 0 ? 'now' : $t_diff."s ago";
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

@php
$id = '';
if(!Auth::guard('user')->guest() && $comment->commentor_type == 'user') {
  $id = Auth::guard('user')->user()->id;
}
elseif(!Auth::guest() && $comment->commentor_type == 'vendor') {
  $id = Auth::user()->id;
}
@endphp

<div class="comment-main {{ $id == $comment->commentor_id ? 'c-right' : 'c-left'}} animate__animated animate__fadeInUp animate__faster">
  <div class="comment row">

    <div class="col-2 col-md-1 pr-1">
      <div class="comments-img"
        style="background-image: url('{{ Storage::url($comment->commentor_type.'/profile/'.$comment->{$comment->commentor_type}->profile_image) }}')">
      </div>
    </div>
    <div class="col-10 col-md-11 pl-0">
      @php
      $name = $comment->commentor_type == 'vendor' ? $comment->vendor->business_name : $comment->user->name;
      @endphp
      <div class="mb-1 d-flex">
        <a href="#" style="color: unset;">
          <strong>{{ $name }}</strong>
          &VerticalSeparator;
          <span class="small"
            style="color: #212529 !important;">{{ '@'.$comment->{$comment->commentor_type}->username }}</span>
        </a>
        <span class="small ml-auto">{{ ftime($comment->created_at) }}</span>
      </div>
      <hr class="m-1">
      <span>
        {{ $comment->content }}
      </span>
    </div>

  </div>
</div>