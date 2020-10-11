<div class="comments-container animate__animated d-none" onclick="closeComments()">
  <div class="comments-inner animate__animated">

    <ul class="nav nav-justified osahan-line-tab" style="box-shadow: 0 5px 10px 0 #00000061">
      <li class="nav-item text-left">
        <a class="nav-link active comments-top-a" style="padding: 0 !important">
          <i class="la la-arrow-left la-lg comments-top-ico" onclick="closeComments()"></i>
          <span class="ml-2"> <i class="la la-comments la-lg"></i> Comments</span>
        </a>
      </li>
    </ul>

    <div class="comments-holder">
      <div class="more-comments">
        <a href=""><strong>Load More Comments...</strong></a>
      </div>

      <div class="comment-main c-left">
        <div class="comment row">

          <div class="col-2 col-md-1 pr-1">
            <div class="comments-img"
              style="background-image: url('{{ Storage::url('vendor/profile/'.Auth::user()->profile_image) }}')"></div>
          </div>
          <div class="col-10 col-md-11 pl-0">
            <div class="mb-1 d-flex">
              <a href="#" style="color: unset;">
                <strong>Name of User</strong>
                &VerticalSeparator;
                <span class="small" style="color: #212529 !important;">@imabi_k</span>
              </a>
              <span class="small ml-auto">22h ago</span>
            </div>
            <hr class="m-1">
            <span>
              This is a test This is a test This is a test This is a test This is a test This is a test This is a test
              This
              is a test This is a test This is a test This is a test
            </span>
          </div>

        </div>
      </div>

      <div class="comment-main c-right">
        <div class="comment row">

          <div class="col-2 col-md-1 pr-1">
            <div class="comments-img"
              style="background-image: url('{{ Storage::url('vendor/profile/'.Auth::user()->profile_image) }}')"></div>
          </div>
          <div class="col-10 col-md-11 pl-0">
            <div class="mb-1 d-flex">
              <a href="#" style="color: unset;">
                <strong>Name of User</strong>
                &VerticalSeparator;
                <span class="small" style="color: #212529 !important;">@imabi_k</span>
              </a>
              <span class="small ml-auto">22h ago</span>
            </div>
            <hr class="m-1">
            <span>
              This is a test This is a test This is a test This is a test This is a test This is a test This is a test
              This
              is a test This is a test This is a test This is a test
            </span>
          </div>

        </div>
      </div>

      <div class="comment-main c-left">
        <div class="comment row">

          <div class="col-2 col-md-1 pr-1">
            <div class="comments-img"
              style="background-image: url('{{ Storage::url('vendor/profile/'.Auth::user()->profile_image) }}')"></div>
          </div>
          <div class="col-10 col-md-11 pl-0">
            <div class="mb-1 d-flex">
              <a href="#" style="color: unset;">
                <strong>Name of User</strong>
                &VerticalSeparator;
                <span class="small" style="color: #212529 !important;">@imabi_k</span>
              </a>
              <span class="small ml-auto">22h ago</span>
            </div>
            <hr class="m-1">
            <span>
              This is a test This is a test This is a test This is a test This is a test This is a test This is a test
              This
              is a test This is a test This is a test This is a test
            </span>
          </div>

        </div>
      </div>
      <div class="comment-main c-left">
        <div class="comment row">

          <div class="col-2 col-md-1 pr-1">
            <div class="comments-img"
              style="background-image: url('{{ Storage::url('vendor/profile/'.Auth::user()->profile_image) }}')"></div>
          </div>
          <div class="col-10 col-md-11 pl-0">
            <div class="mb-1 d-flex">
              <a href="#" style="color: unset;">
                <strong>Name of User</strong>
                &VerticalSeparator;
                <span class="small" style="color: #212529 !important;">@imabi_k</span>
              </a>
              <span class="small ml-auto">22h ago</span>
            </div>
            <hr class="m-1">
            <span>
              This is a test This is a test This is a test This is a test This is a test This is a test This is a test
              This
              is a test This is a test This is a test This is a test
            </span>
          </div>

        </div>
      </div>
    </div>

    <div class="p-3 pt-2 d-flex align-items-center w-100 comments-input-cont bg-white">
      <div class="post-textarea-cont w-100">
        <textarea placeholder="What do you think?..." class="form-control border-0 p-0 shadow-none post-input" required
          name="content" rows="5" id="comment-textarea" name="content"></textarea>
        <small class="text-danger error-message" id="content"></small>
      </div>
    </div>

  </div>
</div>

@push('scripts')
<script>
  $(document).ready(function () {
    $("#comment-textarea").emojioneArea({
      pickerPosition: "top"
    });

    $("#comments-holder").scrollTop($("#comments-holder")[0].scrollHeight);
  });
</script>
@endpush