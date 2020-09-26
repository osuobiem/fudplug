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

<script>
  $(document).ready(function () {
    loadPosts()
  });

  function loadPosts() {
    url = `{{ url('post/get') }}`

    goGet(url)
      .then(res => {
        $('#in-post-container').html(res)
      })
  }
</script>

@endsection