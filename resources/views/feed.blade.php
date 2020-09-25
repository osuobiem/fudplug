@extends('layouts.master')

@section('content')

@if(!Auth::guest())
@include('vendor.components.post-modal')
@endif

<div id="in-post-container"></div>

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