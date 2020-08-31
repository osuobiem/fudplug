<!-- Post Modal Launcher -->
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
        <div class="px-3 pt-2 d-flex align-items-center w-100" href="#">
          <div class="post-textarea-cont-2 w-100">
            <textarea placeholder="Post something delicious..." class="form-control border-0 p-0 shadow-none"
              rows="2"></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Post Modal -->
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

    <!-- Post Text -->
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="px-3 pt-2 d-flex align-items-center w-100" href="#">
          <div class="post-textarea-cont w-100">
            <textarea placeholder="Post something delicious..." class="form-control border-0 p-0 shadow-none post-input"
              rows="5" id="post-textarea"></textarea>
          </div>
        </div>
      </div>
    </div>

    <!-- Media Container -->
    <div class="post-modal-media-container post-media-container">
      <div class="pm pm-4 pmmc-i" style="background-image: url('{{ url('assets/img/test/1.jpg') }}')"></div>
      <div class="pm pm-4 pmmc-i" style="background-image: url('{{ url('assets/img/test/2.jpg') }}')"></div>
      <div class="pm pm-4 pmmc-i" style="background-image: url('{{ url('assets/img/test/3.jpg') }}')"></div>
      <div class="pm pm-4 pmmc-i" style="background-image: url('{{ url('assets/img/test/4.jpg') }}')"></div>
    </div>

    <!-- Post Modal Foot -->
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

      if (window.scrollY >= 130) {
        $('.floating-post-btn-sm').removeClass('d-none animate__fadeOutRight')
        $('.floating-post-btn-sm').addClass('animate__fadeInRight')
      }
      else {
        $('.floating-post-btn-sm').removeClass('animate__fadeInRight')
        $('.floating-post-btn-sm').addClass('animate__fadeOutRight')
      }
    })
  });
</script>