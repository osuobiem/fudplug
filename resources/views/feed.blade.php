@extends('layouts.master')

@section('content')

<main class="col col-lg-6">
  <!-- Post -->
  <div class="box shadow-sm border rounded bg-white mb-3 osahan-post">
    <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
      <div class="dropdown-list-image mr-3 post-profile">
        <img class="rounded-circle" src="{{ url('assets/img/p6.png') }}" alt="">
      </div>
      <div class="font-weight-bold">
        <div class="text-truncate post-profile">Mama Put Chops</div>
        <div class="small post-profile">@mama_put_chops</div>
      </div>
      <span class="ml-auto small">3h ago</span>
    </div>
    <div class="p-3 border-bottom osahan-post-body">
      <p class="mb-0 f-post">
        The cookies taste slightly different and are sold under different names, depending on what region you live in.
        For
        example, the cookie above is a Samoa in some areas and a Caramel De-Lite in others.
      </p>
    </div>
    <div class="p-3 border-bottom osahan-post-footer">
      <a href="#" class="mr-3 text-secondary" title="Like"><i class="la la-heart la-2x text-danger"></i> 16</a>
      <a href="#" class="mr-3 text-secondary" title="Comment"><i class="la la-comment la-2x"></i> 8</a>
      <a href="#" class="mr-3 text-secondary" title="Share"><i class="la la-share la-2x"></i></a>
      <a href="#" class="btn btn-outline-danger btn-sm" style="float: right" title="Save"><i class="la la-bookmark"></i>
        Save Post</a>
    </div>
  </div>

  <!-- Post -->
  <div class="box shadow-sm border rounded bg-white mb-3 osahan-post">
    <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
      <div class="dropdown-list-image mr-3 post-profile">
        <img class="rounded-circle" src="{{ url('assets/img/p6.png') }}" alt="">
      </div>
      <div class="font-weight-bold">
        <div class="text-truncate post-profile">Mama Put Chops</div>
        <div class="small post-profile">@mama_put_chops</div>
      </div>
      <span class="ml-auto small">3h ago</span>
    </div>
    <div class="p-3 border-bottom osahan-post-body">
      <p class="mb-0 f-post">
        The cookies taste slightly different and are sold under different names, depending on what region you live in.
        For
        example, the cookie above is a Samoa in some areas and a Caramel De-Lite in others.
      </p>
    </div>
    <div class="p-3 border-bottom osahan-post-footer">
      <a href="#" class="mr-3 text-secondary" title="Like"><i class="la la-heart la-2x text-danger"></i> 16</a>
      <a href="#" class="mr-3 text-secondary" title="Comment"><i class="la la-comment la-2x"></i> 8</a>
      <a href="#" class="mr-3 text-secondary" title="Share"><i class="la la-share la-2x"></i></a>
      <a href="#" class="btn btn-outline-danger btn-sm" style="float: right" title="Save"><i class="la la-bookmark"></i>
        Save Post</a>
    </div>
  </div>

  <!-- Post -->
  <div class="box shadow-sm border rounded bg-white mb-3 osahan-post">
    <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
      <div class="dropdown-list-image mr-3 post-profile">
        <img class="rounded-circle" src="{{ url('assets/img/p6.png') }}" alt="">
      </div>
      <div class="font-weight-bold">
        <div class="text-truncate post-profile">Mama Put Chops</div>
        <div class="small post-profile">@mama_put_chops</div>
      </div>
      <span class="ml-auto small">3h ago</span>
    </div>
    <div class="p-3 border-bottom osahan-post-body">
      <p class="mb-0 f-post">
        The cookies taste slightly different and are sold under different names, depending on what region you live in.
        For
        example, the cookie above is a Samoa in some areas and a Caramel De-Lite in others.
        The cookies taste slightly different and are sold under different names, depending on what region you live in.
        For
        example, the cookie above is a Samoa in some areas and a Caramel De-Lite in others.
        The cookies taste slightly different and are sold under different names, depending on what region you live in.
        For
        example, the cookie above is a Samoa in some areas and a Caramel De-Lite in others.
      </p>
    </div>
    <div class="p-3 border-bottom osahan-post-footer">
      <a href="#" class="mr-3 text-secondary" title="Like"><i class="la la-heart la-2x text-danger"></i> 16</a>
      <a href="#" class="mr-3 text-secondary" title="Comment"><i class="la la-comment la-2x"></i> 8</a>
      <a href="#" class="mr-3 text-secondary" title="Share"><i class="la la-share la-2x"></i></a>
      <a href="#" class="btn btn-outline-danger btn-sm" style="float: right" title="Save"><i class="la la-bookmark"></i>
        Save Post</a>
    </div>
  </div>

</main>

@endsection