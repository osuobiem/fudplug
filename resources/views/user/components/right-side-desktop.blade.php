<!-- DESKTOP VIEW -->
<div id="desktop-view" class="box mb-3 shadow-sm border rounded bg-white profile-box text-center">
    <div class="py-3 px-3 border-bottom">
        <div class="row justify-content-center">
            <div class="profile-image">
                <img id="avatar" class="rounded-circle shadow-sm"
                    src="{{ Storage::url('user/profile/'.Auth::guard('user')->user()->profile_image) }}" alt="">
                <label for="input" class="status-indicator pimg-icon-hover shadow-sm"><span
                        class="la la-camera-retro text-dark" style="font-size: 24px;"></span></label>
                <input type="file" class="sr-only" id="input" name="image" accept="image/*">
            </div>

        </div>
        <div class="mt-5">
            <h5 class="font-weight-bold text-dark mb-0 mt-2">{{Auth::guard('user')->user()->name}}</h5>
            <p class="text-muted m-1">@<b></b>{{ Auth::guard('user')->user()->username }}</b></p>
        </div>
    </div>
    <div class="d-flex border-bottom">
        <div class="col-6 border-right p-3">
            <h6 class="font-weight-bold text-dark mb-1">Joined</h6>
            <p class="mb-0 text-black-50 small">
                {{ date("d M, Y", strtotime(Auth::guard('user')->user()->created_at)) }}
            </p>
        </div>
        <div class="col-6 p-3">
            <!-- <h6 class="font-weight-bold text-dark mb-1">85</h6>
                            <p class="mb-0 text-black-50 small">Views</p> -->
            <h6 class="font-weight-bold text-dark mb-1">Location</h6>
            <p class="mb-0 text-black-50 small"><i class="las la-map-marker-alt"></i>{{ $user_location->area }},
                {{ $user_location->state }}</p>
        </div>
    </div>
    <div class="d-flex">
        <div class="col-6 border-right p-3">
            <h6 class="font-weight-bold text-dark mb-1">Phone</h6>
            <p class="mb-0 text-black-50 small">
                {{ Auth::guard('user')->user()->phone_number }}
            </p>
        </div>
        <div class="col-6 p-3">
            <!-- <h6 class="font-weight-bold text-dark mb-1">85</h6>
                                            <p class="mb-0 text-black-50 small">Views</p> -->
            <h6 class="font-weight-bold text-dark mb-1">Address</h6>
            <p class="mb-0 text-black-50 small"><i
                    class="las la-map-marker-alt"></i>{{ Auth::guard('user')->user()->address }}</p>
        </div>
    </div>
    <div class="overflow-hidden border-top">
        <a class="font-weight-bold p-3 d-block" data-toggle="modal" href="#profile-edit-modal"> Edit my profile </a>
    </div>
</div>

<script>
    // Initialize crop for profile image
    crop("avatar", "image", "input", "progress", "progress-bar", "alert", "user-image-modal", "change",
        "user-crop", "{{url('user/profile-image-update')}}");

    function crop(...params) {
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
                        viewMode: 3,
                        setDragMode: 'none',
                        aspectRatio: NaN
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
                viewMode: 3,
                setDragMode: 'none',
                aspectRatio: NaN
            });
        }).on("hidden.bs.modal", function () {
            // destroy cropper on modal close
            if (cropper != null) {
                cropper.destroy();
                cropper = null;
            }
        });

        document.getElementById(params[8]).addEventListener("click", function () {
            spin('user-crop');
            $("#user-crop").attr('disabled', true);


            var initialAvatarURL;
            var canvas;

            if (cropper) {
                canvas = cropper.getCroppedCanvas({
                    width: 1000,
                    height: 2000
                });
                initialAvatarURL = avatar.src;
                console.log(params[0]);
                if (params[0] == "avatar") {
                    avatar.src = canvas.toDataURL();
                    $(".img-profile").attr('src', canvas.toDataURL());
                } else {
                    document.getElementById("cover-holder").style.backgroundImage = "url(" + canvas
                        .toDataURL() + ")";
                }

                $alert.removeClass("alert-success alert-warning");
                canvas.toBlob(async function (blob) {
                    var formData = new FormData();
                    var FileSize = blob.size / 1024 / 1024; // Size of uploaded file
                    if (FileSize <= 1) {
                        // Show progress bar if file has required size
                        $progress.show();
                    }

                    // Compress Image On Upload
                    let compressedimage = await compressImg(blob);
                    formData.append("image", blobToFile(compressedimage, params[0] + ".jpg"),
                        params[0] +
                        ".jpg");
                    // Compress Image On Upload


                    $.ajax(upload_url, {
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },

                        xhr: function () {
                            var xhr = new XMLHttpRequest();

                            xhr.upload.onprogress = function (e) {
                                var percent = "0";
                                var percentage = "0%";

                                if (e.lengthComputable) {
                                    percent = Math.round((e.loaded / e.total) *
                                        100);
                                    percentage = percent + "%";
                                    $progressBar.width(percentage).attr(
                                        "aria-valuenow",
                                        percent).text(percentage);
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
                                spin('user-crop');
                                $("#user-crop").removeAttr('disabled');
                            } else {
                                setTimeout(function () {
                                    $progress.hide();
                                    $modal.modal("hide");
                                    spin('user-crop');
                                    $("#user-crop").removeAttr('disabled');
                                }, 2000);
                            }
                        },

                        error: function (res) {
                            spin('user-crop');
                            $("#user-crop").removeAttr('disabled');
                            showAlert(false, "Oops! Something's not right. Try again");

                            avatar.src = initialAvatarURL;
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

</script>
