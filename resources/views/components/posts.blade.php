@if(count($posts))

{{-- Format Time/Date --}}
@php
function format_time($time) {
  $time = strtotime($time);
  $t_diff = time() - $time;
  $res = "";

  if($t_diff >= 1 && $t_diff < 60) {
    $res = $t_diff."s ago";
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

@foreach ($posts as $post)
    <!-- Post -->
<div class="box shadow-sm border rounded bg-white mb-3 osahan-post">
  <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
    <div class="dropdown-list-image mr-3 post-profile">
      <img class="rounded-circle" src="{{ Storage::url('vendor/profile/'.$post->vendor->profile_image) }}" alt="">
    </div>
    <div class="font-weight-bold">
      <div class="text-truncate post-profile">{{ $post->vendor->business_name }}</div>
      <div class="small post-profile">{{ '@'.$post->vendor->username }}</div>
    </div>
    <span class="ml-auto small">{{ format_time($post->created_at) }}</span>
  </div>
  <div class="p-3 border-bottom osahan-post-body">
    <p class="mb-0 f-post">
      {{ $post->content }}
    </p>

    <div class="post-media-container justify-content-center">
      @if($post->media)
        @foreach($post->media as $media)
          @if($media->type == 'image')
          <div class="pm pm-im-l pm-{{ count($post->media) }}" onclick="launchLight('{{ $media->id }}')" style="background-image: url('{{ Storage::url('posts/photos/'.$media->name) }}')"><div></div></div>
          @else
          @php $thumb = explode('.', $media->name)[0] . '.png'; @endphp
          <div class="w-100 feed-vid-cont" onfocus="trackPosition('{{ $media->name }}', 'med-{{ $media->id }}', 'play{{ $media->id }}')" id="med-{{ $media->id }}">
            <img class="pm-1 vid-bod" src="{{ Storage::url('posts/videos/thumbnails/'.$thumb) }}" />
          </div>
          
          <div class="spinner-border play-btn p-4" style="display: none" id="play{{ $media->id }}-spinner" role="status">
            <span class="sr-only">Loading...</span>
          </div>

          <i class="la la-play-circle la-5x play-btn" onclick="playVideo('{{ $media->name }}', 'med-{{ $media->id }}', 'play{{ $media->id }}')" id="play{{ $media->id }}-txt"></i>

          @endif
        @endforeach
      @endif
    </div>
  </div>

  {{-- Lightbox --}}
  <div uk-lightbox>
    @foreach($post->media as $media)
      @if($media->type == 'image')
      <a class="d-none" href="{{ Storage::url('posts/photos/'.$media->name) }}" id="light-{{ $media->id }}"></a>
      @endif
    @endforeach
  </div>

  @php 
  $is_liker = false;

  if(!Auth::guest() || !Auth::guard('user')->guest()) {
    $liker_type = Auth::guest() ? 'user' : 'vendor';
    $liker = Auth::guest() ? Auth::guard('user')->user() : Auth::user();

    $is_liker = $post->like()->where('liker_id', $liker->id)->where('liker_type', $liker_type)->count();

    $is_liker = $is_liker > 0 ? true : false;
  }
  @endphp

  {{-- Actions --}}
  <div class="p-3 border-bottom osahan-post-footer">
    <a class="mr-3 text-secondary" title="Like"><i class="la {{ $is_liker ? 'la-heart' : 'la-heart-o'}} la-2x text-danger" like-count="{{ $post->likes }}" onclick="{{ $is_liker ? 'unlikePost(`'.$post->id.'`, this)' : 'likePost(`'.$post->id.'`, this)' }}"></i><span>&nbsp;{{ $post->likes }}</span></a>
    <a href="#" class="mr-3 text-secondary" title="Comment"><i class="la la-comment la-2x"></i> {{ $post->comments }}</a>
    <a href="#" class="mr-3 text-secondary" title="Share"><i class="la la-share la-2x"></i></a>
    <a href="#" class="btn btn-outline-danger btn-sm" style="float: right" title="Save"><i class="la la-bookmark"></i>
      Save Post</a>
  </div>
</div>
@endforeach
@else
<div class="box shadow-sm border rounded bg-white mb-3 osahan-post">
  <div class="p-3 d-flex align-items-center border-bottom osahan-post-header justify-content-center">
    <p class="m-0"><strong>No Posts Yet!</strong></p>
  </div>
</div>
@endif