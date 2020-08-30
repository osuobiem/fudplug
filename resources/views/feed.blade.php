@extends('layouts.master')

@section('content')

<div id="post-modal-init">
  <div class="box shadow-sm border rounded bg-white mb-3 osahan-share-post">
    <ul class="nav nav-justified border-bottom osahan-line-tab" id="myTab" role="tablist">
      <li class="nav-item text-left">
        <a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home"
          aria-selected="true"><i class="la la-utensil-spoon la-lg"></i> What did you cook today?
        </a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="p-4 d-flex align-items-center w-100" href="#">
          <div class="w-100">
            <textarea placeholder="Post something delicious..." class="form-control border-0 p-0 shadow-none"
              rows="1"></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="post-modal post-modal animate__animated animate__fadeIn d-none">
  <div class="box shadow-sm border rounded bg-white mb-3 osahan-share-post">
    <ul class="nav nav-justified border-bottom osahan-line-tab" id="myTab" role="tablist">
      <li class="nav-item text-left">
        <a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home"
          aria-selected="true"><i class="la la-utensil-spoon la-lg"></i> What did you cook today?
          <i class="la la-times-circle la-lg post-ico py-1" id="close-post"></i>
        </a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="p-4 d-flex align-items-center w-100" href="#">
          <div class="w-100">
            <textarea placeholder="Post something delicious..." autofocus="true"
              class="form-control border-0 p-0 shadow-none post-input" rows="5"></textarea>
          </div>
        </div>
      </div>
    </div>
    <div class="border-top p-3 d-flex align-items-center">
      <div class="mr-auto">
        <a href="#" class="post-ico"><i class="la la-camera-retro la-2x p-1"></i></a>
        <a href="#" class="ml-2 post-ico"><i class="la la-video la-2x p-1"></i></a>
      </div>
      <button type="button" class="btn btn-outline-danger px-5 btn-lg post-btn">Post</button>
    </div>
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

    <div class="post-media-container">
      <div class="pm pm-1" style="background-image: url('{{ url('assets/img/test/1.jpg') }}')"></div>
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

    <div class="post-media-container">
      <div class="pm pm-2" style="background-image: url('{{ url('assets/img/test/1.jpg') }}')"></div>
      <div class="pm pm-2" style="background-image: url('{{ url('assets/img/test/2.jpg') }}')"></div>
    </div>
  </div>
  <div class="p-3 border-bottom osahan-post-footer">
    <a href="#" class="mr-3 text-secondary" title="Like"><i class="la la-heart la-2x"></i> 16</a>
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

    <div class="post-media-container">
      <div class="pm pm-3" style="background-image: url('{{ url('assets/img/test/1.jpg') }}')"></div>
      <div class="pm pm-3" style="background-image: url('{{ url('assets/img/test/2.jpg') }}')"></div>
      <div class="pm pm-3" style="background-image: url('{{ url('assets/img/test/3.jpg') }}')"></div>
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

    <div class="post-media-container">
      <div class="pm pm-4" style="background-image: url('{{ url('assets/img/test/1.jpg') }}')"></div>
      <div class="pm pm-4" style="background-image: url('{{ url('assets/img/test/2.jpg') }}')"></div>
      <div class="pm pm-4" style="background-image: url('{{ url('assets/img/test/3.jpg') }}')"></div>
      <div class="pm pm-4" style="background-image: url('{{ url('assets/img/test/4.jpg') }}')"></div>
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

@endsection