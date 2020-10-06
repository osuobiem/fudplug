@extends('layouts.master')

@section('content')

@if(!Auth::guest())
@include('vendor.components.post-modal')
@endif

<div id="in-post-container">
  <div class="justify-content-center text-center w-100 pb-2 box shadow-sm border rounded bg-white p-2">
    <p><strong>Loading Feed</strong></p>
    <div class="spinner-border spinner-border-sm btn-pr p-2" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function () {
    loadPosts()
  });

  // Load Posts
  function loadPosts() {
    url = `{{ url('post/get') }}`

    goGet(url)
      .then(res => {
        $('#in-post-container').html(res)
      })
  }

  // Play Post Video
  function playVideo(vid, container, oth) {
    spin(oth)

    video_url = `{{ Storage::url('posts/videos/') }}${vid}`;
    container = document.getElementById(container)

    var video = document.createElement('video')

    video.setAttribute(
      "class",
      "pm-1 vid-bod"
    );

    video.setAttribute(
      "id",
      oth + "-video"
    );


    video.setAttribute(
      "src",
      video_url
    );

    video.setAttribute('controls', true)

    // Monitor video load
    var timer = setInterval(function () {
      if (video.readyState === 4) {
        $('#' + oth + '-spinner').addClass('d-none')
        container.innerHTML = '';
        container.append(video)

        $('.vid-bod').trigger('pause')
        $('#' + oth + '-video').trigger('play')

        video.setAttribute(
          "onplay",
          `pauseOthers('${oth}-video')`
        );

        clearInterval(timer);
      }
    }, 1000);
  }

  // Pause other videos
  function pauseOthers(id) {
    $('#' + id).removeClass('vid-bod');
    $('.vid-bod').trigger('pause')
    $('#' + id).addClass('vid-bod');
  }
</script>

@endpush