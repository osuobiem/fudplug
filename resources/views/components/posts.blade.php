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
    <span class="ml-auto small">3h ago</span>
  </div>
  <div class="p-3 border-bottom osahan-post-body">
    <p class="mb-0 f-post">
      {{ $post->content }}
    </p>

    <div class="post-media-container justify-content-center">
      @if($post->media)
        @foreach($post->media as $media)
          @if($media->type == 'image')
          <div class="pm pm-{{ count($post->media) }}" style="background-image: url('{{ Storage::url('posts/photos/'.$media->name) }}')"></div>
          @else
          @php $thumb = explode('.', $media->name)[0] . '.png'; @endphp
          <div class="w-100">
            <img class="pm-1" style="border: solid #dee2e6 1px;" src="{{ Storage::url('posts/videos/thumbnails/'.$thumb) }}" />
          </div>
          <i class="la la-play-circle la-5x play-btn"></i>
          @endif
        @endforeach
      @endif
    </div>
  </div>
  <div class="p-3 border-bottom osahan-post-footer">
    <a href="#" class="mr-3 text-secondary" title="Like"><i class="la la-heart la-2x text-danger"></i> 16</a>
    <a href="#" class="mr-3 text-secondary" title="Comment"><i class="la la-comment la-2x"></i> 8</a>
    <a href="#" class="mr-3 text-secondary" title="Share"><i class="la la-share la-2x"></i></a>
    <a href="#" class="btn btn-outline-danger btn-sm" style="float: right" title="Save"><i class="la la-bookmark"></i>
      Save Post</a>
  </div>
</div>
@endforeach