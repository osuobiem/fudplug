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

    <!-- Post Form -->
    <form id="post-form" method="POST">
      @csrf
      <!-- Post Text -->
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div class="px-3 pt-2 d-flex align-items-center w-100" href="#">
            <div class="post-textarea-cont w-100">
              <textarea placeholder="Post something delicious..."
                class="form-control border-0 p-0 shadow-none post-input" required name="content" rows="5"
                id="post-textarea" name="content"></textarea>
              <small class="text-danger error-message" id="content"></small>
            </div>
          </div>
        </div>
      </div>

      <input type="file" accept="image/*" multiple id="image-1" class="d-none" onchange="fill(this)">
      <input type="file" accept="image/*" multiple id="image-2" class="d-none" onchange="fill(this)">
      <input type="file" accept="image/*" multiple id="image-3" class="d-none" onchange="fill(this)">
      <input type="file" accept="image/*" multiple id="image-4" class="d-none" onchange="fill(this)">
      <input type="file" accept="video/*" multiple id="video-file" class="d-none" onchange="fillVideo(this)">

      <!-- Media Container -->
      <div class="post-modal-media-container post-media-container" id="post-media-container">
      </div>

      <!-- Post Modal Foot -->
      <div class="border-top p-3 d-flex align-items-center">
        <div class="mr-auto">
          <a href="#" id="pick-image" class="post-ico"><i class="la la-camera-retro la-2x p-1 icon-hover"></i></a>
          <a href="#" id="pick-video" class="ml-2 post-ico"><i class="la la-video la-2x p-1 icon-hover"></i></a>
        </div>
        <button type="button" class="btn btn-outline-danger px-5 btn-lg" onclick="submitPost()" type="submit"
          id="post-btn">
          <span id="post-txt">Post</span>
          <div class="spinner-border spinner-border-sm btn-pr" id="post-spinner" style="display: none;" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </button>
      </div>

    </form>
    <!--/ Post Form -->
  </div>
</div>

<script>
  let images = {};
  let video = {};

  $(document).ready(function () {
    $('#post-form').submit(el => {
      sendPost(el)
    })

    $("#post-textarea").emojioneArea({
      pickerPosition: "bottom"
    });

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

    imageCounter = 1;

    $('#pick-image').click(() => {
      if (imageCounter >= 5) {
        showAlert(false, "You can't upload more than 4 images")
      }
      else {
        $('#image-' + imageCounter).click()
      }
    })

    $('#pick-video').click(() => {
      if (Object.keys(video).length > 0) {
        showAlert(false, "You can't upload more than 1 video")
      }
      else {
        $('#video-file').click()
      }
    })
  });

  // Send Post
  function sendPost(el) {
    el.preventDefault()

    spin('post')

    let url = `{{ url('post/create') }}`;
    let data = new FormData(el.target)

    // Attach images to form data
    if (Object.keys(images).length > 0) {
      for (image in images) {
        data.append('images[]', images[image])
      }
    }

    goPost(url, data)
      .then(res => {
        spin('post')

        handleFormRes(res);
      })
      .catch(err => {
        spin('post')
        handleFormRes(err);
      })
  }

  // Fill Picked Image in Div
  function fill(input) {
    sendErr = false;

    if (input.files) {
      [...input.files].forEach((file, ind) => {
        if (imageCounter < 5) {
          if (file.size > 26214400) {
            showAlert(false, "Image size must not be more than 25MB");
            imageCounter -= 1
          } else if (file.type.split("/")[0] != "image") {
            showAlert(false, "The file is not an image");
            imageCounter -= 1
          } else {
            var img = document.createElement('div')
            var reader = new FileReader();

            reader.onload = (e) => {
              img.setAttribute(
                "style",
                'background: url("' + e.target.result + '")'
              );
            };

            document.getElementById('post-media-container').prepend(img)

            inputId = $(input).attr('id')

            reader.readAsDataURL(file);

            pid = `pmmc-i-${Math.floor(Math.random() * 10)}-${ind}`
            img.setAttribute('class', 'pm pmmc-i')
            img.setAttribute('id', pid)
            img.innerHTML = `<span class="pmmc-ix" onclick="removePostImg('${pid}')"><i class="la la-times la-lg"></i></span>`;

            images[pid] = file
          }
        }
        else {
          sendErr = true;
        }
        imageCounter++
      })
      sendErr ? showAlert(false, "You can't upload more than 4 images") : null
      arrangeImages()
    }
  }

  // Fill Picked Video in Div
  function fillVideo(input) {
    if (input.files) {
      [...input.files].forEach((file, ind) => {
        if (file.size > 536870912) {
          showAlert(false, "Video size must not be more than 512MB");
        } else if (file.type.split("/")[0] != "video") {
          showAlert(false, "The file is not a video");
        } else {
          var vid = document.createElement('div')
          var reader = new FileReader();

          reader.onload = (e) => {
            vid.setAttribute(
              "style",
              'background: url("' + e.target.result + '")'
            );
          };

          document.getElementById('post-media-container').prepend(vid)
          reader.readAsDataURL(file);

          vid.innerHTML = `<span class="pmmc-ix" onclick="removePostVid('${ind}')"><i class="la la-times la-lg"></i></span>`;

          video = file
        }
      })
    }
  }

  // Arrange Post media images
  function arrangeImages() {
    switch (imageCounter) {
      case 2:
        $('.pmmc-i').attr('class', 'pm pm-1 pmmc-i')
        break;

      case 3:
        $('.pmmc-i').attr('class', 'pm pm-2 pmmc-i')
        break;

      case 4:
        $('.pmmc-i').attr('class', 'pm pm-3 pmmc-i')
        break;

      default:
        $('.pmmc-i').attr('class', 'pm pm-4 pmmc-i')
        break;
    }
  }

  // Remove Post Image
  function removePostImg(id) {
    $('#' + id).remove()
    delete images[id]
    imageCounter = $('.pmmc-i').length + 1
    arrangeImages()
  }

  // Submit Post
  function submitPost() {
    $('#post-form').submit();
  }
</script>