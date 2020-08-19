@extends('layouts.master')

@section('content')

<main class="col col-lg-6" id="main-content">
  <div class="box shadow-sm border rounded bg-white p-5 text-center">
    <div class="spinner-border" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
</main>

<script>
  $(document).ready(function () {

    url = `{{ url('feed') }}`

    goGet(url)
      .then(res => {
        $('#main-content').html(res)
      })
      .catch(err => {
        showAlert(false, "Oops! Something's not right. Please Reload Page")
      })
  });
</script>

@endsection