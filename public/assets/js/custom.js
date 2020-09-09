// Fill Picked Image in Div
function fillImage(input, fillId) {
  let img = document.getElementById(fillId);

  if (input.files && input.files[0]) {
    if (input.files[0].size > 5120000) {
      showAlert(false, "Image size must not be more than 5MB");
    } else if (input.files[0].type.split("/")[0] != "image") {
      console.log("red");
      showAlert(false, "The file is not an image");
    } else {
      var reader = new FileReader();

      reader.onload = e => {
        img.setAttribute("style", 'background: url("' + e.target.result + '")');
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
}

// Pick Image
function pickImage(inputId) {
  $("#" + inputId).click();
}

// Show Alert
function showAlert(status, message) {
  if (!status) {
    $("#alert-error").html(message);
    $("#alert-error").removeClass("d-none");

    setTimeout(() => {
      $("#alert-error").addClass("d-none");
      $("#alert-error").html("");
    }, 4000);
  } else {
    $("#alert-success").html(message);
    $("#alert-success").removeClass("d-none");

    setTimeout(() => {
      $("#alert-success").addClass("d-none");
      $("#alert-success").html("");
    }, 4000);
  }
}

// Generic Ajax GET function
function goGet(url) {
  return new Promise((resolve, reject) => {
    $.ajax({type: "GET", url}).then(res => {
      resolve(res);
    }).catch(err => {
      reject(err);
    });
  });
}

// Generic Ajax POST function
function goPost(url, data) {
  return new Promise((resolve, reject) => {
    $.ajax({type: "POST", url, data, processData: false, contentType: false}).then(res => {
      resolve(res);
    }).catch(err => {
      reject(err);
    });
  });
}

// Handle form error
function handleFormError(err, form = false, prefix = false) {
  if (err.status === 400) {
    errors = err.responseJSON.message;

    if (typeof errors === "object") {
      for (const [key, value] of Object.entries(errors)) {
        e = prefix
          ? document.getElementById(prefix + "-" + key)
          : document.getElementById(key);
        e.innerHTML = "";
        [...value].forEach(m => {
          e.innerHTML += `<p>${m}</p>`;
        });
      }
    } else {
      if (form) {
        $("#" + form).html(errors);
        $("#" + form).removeClass("d-none");
      } else {
        showAlert(false, errors);
      }
    }
  } else {
    if (form) {
      $("#" + form).html("Oops! Something's not right. Try Again");
      $("#" + form).removeClass("d-none");
    } else {
      showAlert(false, "Oops! Something's not right. Try Again");
    }
  }
}

// Toggle Spinner
let btnDis = false;

function spin(id) {
  btnDis = btnDis
    ? false
    : true;
  $(`#${id}-txt`).toggle();
  $(`#${id}-spinner`).toggle();

  btnDis
    ? $(`#${id}-btn`).attr("disabled", true)
    : $(`#${id}-btn`).removeAttr("disabled");
}

// Turn off Form Errors
function offError(form = false) {
  $(".error-message").html("");
  form
    ? $("#" + form).addClass("d-none")
    : null;
}

// Pop Post Modal
let modalActive = false;

$(".post-modal-init").click(() => {
  modalActive
    ? null
    : popPostModal();
  modalActive = true;
});

$("#close-post").click(() => {
  !modalActive
    ? null
    : closePostModal();
  modalActive = false;
});

function popPostModal() {
  $(".post-modal").removeClass("d-none");
  $("#post-textarea").focus();
}

function closePostModal() {
  $(".post-modal").addClass("d-none");
}

// Cropper.JS Initialize any crop by calling the crop function
window.addEventListener("DOMContentLoaded", function () {
  // Initialize crop for profile image
  crop("avatar", "image", "input", "progress", "progress-bar", "alert", "modal", "change", "crop", "profile_image_update");

  // Initialize crop for cover image
  crop("cover", "cover-image", "cover-input", "progress", "progress-bar", "alert", "cover-modal", "cover-change", "cover-crop", "cover_image_update");
});

function crop(...params) {
  // var avatar = document.getElementById('avatar');
  // var image = document.getElementById('image');
  // var input = document.getElementById('input');
  // var $progress = $('.progress');
  // var $progressBar = $('.progress-bar');
  // var $alert = $('.alert');
  // var $modal = $('#modal');

  var avatar = document.getElementById(params[0]);
  var image = document.getElementById(params[1]);
  var input = document.getElementById(params[2]);
  var $progress = $("." + params[3]);
  var $progressBar = $("." + params[4]);
  var $alert = $("." + params[5]);
  var $modal = $("#" + params[6]);
  var $change = $("#" + params[7]);
  var $crop = $("#" + params[8]);
  var upload_url = params[9];
  var cropper;

  $('[data-toggle="tooltip"]').tooltip();

  input.addEventListener("change", function (e) {
    var files = e.target.files;
    var done = function (url) {
      input.value = "";
      image.src = url;
      $alert.hide();
      // Show crop modal when modal not visible
      if (!$modal.is(":visible")) {
        $change.addClass("d-none");
        $crop.removeClass("d-none");
        $modal.modal("show");
      } else {
        $change.addClass("d-none");
        $crop.removeClass("d-none");
        // Reinitialize ccropper when file change button is clicked
        cropper = new Cropper(image, {
          aspectRatio: 1,
          viewMode: 3
        });
      }
    };
    var reader;
    var file;
    var url;

    if (files && files.length > 0) {
      file = files[0];

      if (URL) {
        done(URL.createObjectURL(file));
      } else if (FileReader) {
        reader = new FileReader();
        reader.onload = function (e) {
          done(reader.result);
        };
        reader.readAsDataURL(file);
      }
    }
  });

  // Initialize cropper on modal popup
  $modal.on("shown.bs.modal", function () {
    cropper = new Cropper(image, {
      aspectRatio: 1,
      viewMode: 3
    });
  }).on("hidden.bs.modal", function () {
    // destroy cropper on modal close
    if (cropper != null) {
      cropper.destroy();
      cropper = null;
    }
  });

  document.getElementById(params[8]).addEventListener("click", function () {
    var initialAvatarURL;
    var canvas;

    if (cropper) {
      canvas = cropper.getCroppedCanvas({width: 1000, height: 2000});
      initialAvatarURL = avatar.src;
      console.log(params[0]);
      if (params[0] == "avatar") {
        avatar.src = canvas.toDataURL();
      } else {
        document.getElementById("cover-holder").style.backgroundImage = "url(" + canvas.toDataURL() + ")";
      }

      $alert.removeClass("alert-success alert-warning");
      canvas.toBlob(function (blob) {
        var formData = new FormData();
        var FileSize = blob.size / 1024 / 1024; // Size of uploaded file
        if (FileSize <= 1) {
          // Show progress bar if file has required size
          $progress.show();
        }

        formData.append("image", blobToFile(blob, params[0] + ".jpg"), params[0] + ".jpg");
        $.ajax(upload_url, {
          method: "POST",
          data: formData,
          processData: false,
          contentType: false,

          xhr: function () {
            var xhr = new XMLHttpRequest();

            xhr.upload.onprogress = function (e) {
              var percent = "0";
              var percentage = "0%";

              if (e.lengthComputable) {
                percent = Math.round((e.loaded / e.total) * 100);
                percentage = percent + "%";
                $progressBar.width(percentage).attr("aria-valuenow", percent).text(percentage);
              }
            };

            return xhr;
          },

          success: function (res) {
            if (res.success == false) {
              let message = res.message.image[0];
              $alert.show().addClass("alert-danger").text(message);
              $crop.addClass("d-none");
              $change.removeClass("d-none");
              // Reset cropper on error
              cropper.destroy();
              cropper = null;
              // Reset cropper on error
            } else {
              //$progress.hide();
              setTimeout(function () {
                $modal.modal("hide");
              }, 2000);
            }
          },

          error: function (res) {
            avatar.src = initialAvatarURL;
            console.log(res.responseJSON);
          }

          // complete: function () {
          //     $progress.hide();
          //     setTimeout(function () {
          //         $modal.modal('hide');
          //     }, 2000);
          // },
        });
      });
    }
  });
}

function blobToFile(theBlob, fileName) {
  //A Blob() is almost a File() - it's just missing the two properties below which we will add
  theBlob.lastModifiedDate = new Date();
  theBlob.name = fileName;
  return theBlob;
}
