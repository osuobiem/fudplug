{{-- info/Pop Modal --}}
<div class="post-modal-init">
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

{{-- Post Modal --}}
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
            <textarea placeholder="Post something delicious..." class="form-control border-0 p-0 shadow-none post-input"
              rows="5" id="post-textarea"></textarea>
          </div>
        </div>
      </div>
    </div>
    <div class="border-top p-3 d-flex align-items-center">
      <div class="mr-auto">
        <a href="#" class="post-ico"><i class="la la-camera-retro la-2x p-1 icon-hover"></i></a>
        <a href="#" class="ml-2 post-ico"><i class="la la-video la-2x p-1 icon-hover"></i></a>
      </div>
      <button type="button" class="btn btn-outline-danger px-5 btn-lg post-btn">Post</button>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $(this).scroll(() => {
      if (window.scrollY >= 141) {
        $('.floating-post-btn').removeClass('animate__fadeOutDown')
        $('.floating-post-btn').addClass('d-lg-block animate__fadeInUp')
      }
      else {
        $('.floating-post-btn').removeClass('animate__fadeInUp')
        $('.floating-post-btn').addClass('animate__fadeOutDown')
      }
    })
  });
</script>