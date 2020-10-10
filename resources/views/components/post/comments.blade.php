<div class="comments-container animate__animated d-none">
  <div class="comments-inner animate__animated">
    <ul class="nav nav-justified osahan-line-tab" role="tablist">
      <li class="nav-item text-left">
        <a class="nav-link active comments-top-a" style="padding: 0 !important">
          <i class="la la-arrow-left la-lg comments-top-ico" onclick="closeComments()"></i>
          <span class="ml-2">Comments</span>
        </a>
      </li>
    </ul>

    <div class="p-3 pt-2 d-flex align-items-center w-100 comments-input-cont">
      <div class="post-textarea-cont w-100">
        <textarea placeholder="What do you think?..." class="form-control border-0 p-0 shadow-none post-input" required
          name="content" rows="5" id="post-textarea" name="content"></textarea>
        <small class="text-danger error-message" id="content"></small>
      </div>
    </div>

  </div>
</div>