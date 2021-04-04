@extends('layouts.master')

@section('content')

<style>
    #cover-holder {
        background-image: url("{{ Storage::url('vendor/cover/'.Auth::user('vendor')->cover_image) }}");
    }

</style>

<div class="box mb-3 shadow-sm border rounded bg-white profile-box">

    <div id="cover-holder">
        <!-- Cover image holder -->
        <img id="cover" src="{{ Storage::url('vendor/cover/'.Auth::user('vendor')->cover_image) }}" class="d-none">
        <!-- Cover image file input -->
        <input type="file" class="sr-only" id="cover-input" name="cover-image" accept="image/*">

        <!-- <a href="#profile-edit-modal" data-toggle="modal" target="_blank" title="edit profile"
            rel="noopener noreferrer">
            <i class="la la-ellipsis-v la-2x icon-hover text-white" style="margin-left: 90%;"></i>
        </a> -->
        <div class="profile-dropdown">
            <a class="" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="la la-ellipsis-v la-2x icon-hover text-white"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <label class="dropdown-item" id="profile-edit-btn" type="button">Edit
                    Profile</label>
                <label type="button" class="dropdown-item" for="input">Change Profile Image</label>
                <label type="button" class="dropdown-item" for="cover-input">Change Cover Photo</label>
            </div>
        </div>

        <div class="py-4 px-3 border-bottom text-center">
            <img id="avatar" style="width:100px;height:100px;border-radius:50%;object-fit:cover;overflow:hidden;"
                src="{{ Storage::url('vendor/profile/'.Auth::user('vendor')->profile_image) }}"
                class="mt-2 img-fluid rounded-circle" alt="Responsive image">
            <input type="file" class="sr-only" id="input" name="image" accept="image/*">
            <br />

            <h5 class="font-weight-bold text-white mb-n3 mt-0">{{ Auth::user('vendor')->business_name }}</h5>
            <p class="mb-0 text-white">@<b>{{ Auth::user('vendor')->username }}</b></p>
        </div>
    </div>
    <div class="text-center">
        <div class="row">
            <div class="col-6 border-right p-2">
                <h6 class="font-weight-bold text-dark mb-1">Joined</h6>
                <p class="mb-0 text-black-50 small">{{ date("d M, Y", strtotime(Auth::user('vendor')->created_at)) }}
                </p>
            </div>
            <div class="col-6 p-2">
                <h6 class="font-weight-bold text-dark mb-1">Location</h6>
                <p class="mb-0 text-black-50 small"><i class="las la-map-marker-alt"></i>{{ $vendor_location->area }},
                    {{ $vendor_location->state }}</p>
            </div>
        </div>
        <div class="overflow-hidden border-top">
            <!-- <a class="font-weight-bold p-3 d-block" href="sign-in.html"> Log Out </a> -->
            <div class="text-center">
                <ul class="nav border-bottom d-flex justify-content-center osahan-line-tab" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                            aria-selected="false">Feed</a>
                    </li>
                    <!-- <li class="nav-item d-lg-none">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#order" role="tab"
                            aria-controls="home" aria-selected="false">Orders</a>
                    </li> -->
                    <li class="nav-item d-lg-none">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#menu-dish" role="tab"
                            aria-controls="home" aria-selected="false">Menu/Dishes</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="">
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="box shadow-sm border rounded bg-white mb-3">
                <div class="box-title border-bottom p-3">
                    <h6 class="m-0">Overview</h6>
                </div>
                <div class="box-body">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr class="border-bottom">
                                <th class="p-3">Email</th>
                                <td class="p-3">{{ Auth::user('vendor')->email }}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th class="p-3">Phone</th>
                                <td class="p-3">{{ Auth::user('vendor')->phone_number }}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th class="p-3">Address</th>
                                <td class="p-3">{{ Auth::user('vendor')->address }}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th class="p-3">Media Handles</th>
                                <td class="p-3">
                                    <ul class="list-inline">
                                        @if(!empty($social_handles->instagram))
                                        <li class="list-inline-item">
                                            <a href="{{ $social_handles->instagram }}" target="_blank"
                                                rel="noopener noreferrer">
                                                <i class="la la-instagram text-warning m-0"
                                                    style="font-size:25px; font-weight: bold;"></i>
                                            </a>
                                        </li>
                                        @endif

                                        @if(!empty($social_handles->facebook))
                                        <li class="list-inline-item">
                                            <a href="{{ $social_handles->facebook }}" target="_blank"
                                                rel="noopener noreferrer">
                                                <i class="la la-facebook text-primary"
                                                    style="font-size:25px; font-weight: bold;"></i>
                                            </a>
                                        </li>
                                        @endif

                                        @if(!empty($social_handles->twitter))
                                        <li class="list-inline-item">
                                            <a href="{{ $social_handles->twitter }}" target="_blank"
                                                rel="noopener noreferrer">
                                                <i class="la la-twitter text-info"
                                                    style="font-size:25px; font-weight: bold;"></i>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <th class="p-3">About</th>
                                <td class="p-3">{{ Auth::user('vendor')->about_business }}</td>
                            </tr>
                            <tr>
                                <th class="">User Rating</th>
                                <td class="">
                                    <!-- Rating Stars Box -->
                                    <div @if($rating_data['user_rating']) @else id="rating-view" @endif
                                        class='rating-stars text-left float-left d-inline' title="Rate Vendor">
                                        <ul id='stars'>
                                            <li class='star' data-value='1'>
                                                <i class='lar la-star fa-fw'></i>
                                            </li>
                                            <li class='star' data-value='2'>
                                                <i class='lar la-star fa-fw'></i>
                                            </li>
                                            <li class='star' data-value='3'>
                                                <i class='lar la-star fa-fw'></i>
                                            </li>
                                            <li class='star' data-value='4'>
                                                <i class='lar la-star fa-fw'></i>
                                            </li>
                                            <li class='star' data-value='5'>
                                                <i class='lar la-star fa-fw'></i>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Rating Stars Box -->
                                    <div class="d-inline" id="rating-holder">
                                        @if($rating_data['user_rating'])
                                        <div class="ml-3 d-inline float-left mt-1 font-weight-bold">
                                            <span>{{ $rating_data['total_rating'] }}</span>/5
                                            <sub class="d-block">You have rated this vendor.</sub>
                                        </div>
                                        @else
                                        <div class="ml-3 d-inline float-left mt-2 font-weight-bold">
                                            <span id="rating-val">{{ $rating_data['total_rating'] }}</span>/5
                                        </div>
                                        @endif
                                    </div>
                                    <!-- Rating Modal -->
                                    @include('user.components.rating')
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="box shadow-sm border rounded bg-white mb-3 p-3">
                <!-- <div class="box-title border-bottom p-3">
                    <h6 class="m-0">About</h6>
                </div>
                <div class="box-body p-3">
                    <p>{{ Auth::user('vendor')->about_business }}</p>
                </div> -->
                <div class="alert alert-warning">
                    Coming soon
                </div>
            </div>
        </div>


        <div class="tab-pane fade d-lg-none" id="order" role="tabpanel" aria-labelledby="order-tab">

            <div class="box shadow-sm border rounded bg-white mb-3">
                <div class="box-title border-bottom p-3">
                    <h6 class="m-0">Orders</h6>
                </div>
                <div class="box-body p-3 h-100 overflow-auto">
                    <div class="d-flex align-items-center osahan-post-header mb-3 people-list">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="{{ url('assets/img/p4.png') }}" alt="">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold mr-2">
                            <div class="text-truncate">Sophia Lee</div>
                            <div class="small text-gray-500">@Harvard
                            </div>
                        </div>
                        <span class="ml-auto"><button type="button" class="btn btn-outline-danger btn-sm">View</button>
                        </span>
                    </div>
                    <div class="d-flex align-items-center osahan-post-header mb-3 people-list">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="{{ url('assets/img/p9.png') }}" alt="">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold mr-2">
                            <div class="text-truncate">John Doe</div>
                            <div class="small text-gray-500">Traveler
                            </div>
                        </div>
                        <span class="ml-auto"><button type="button" class="btn btn-outline-danger btn-sm">View</button>
                        </span>
                    </div>
                    <div class="d-flex align-items-center osahan-post-header mb-3 people-list">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="{{ url('assets/img/p10.png') }}" alt="">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold mr-2">
                            <div class="text-truncate">Julia Cox</div>
                            <div class="small text-gray-500">Art Designer
                            </div>
                        </div>
                        <span class="ml-auto"><button type="button" class="btn btn-outline-danger btn-sm">View</button>
                        </span>
                    </div>
                    <div class="d-flex align-items-center osahan-post-header mb-3 people-list">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="{{ url('assets/img/p11.png') }}" alt="">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold mr-2">
                            <div class="text-truncate">Robert Cook</div>
                            <div class="small text-gray-500">@Photography
                            </div>
                        </div>
                        <span class="ml-auto"><button type="button" class="btn btn-outline-danger btn-sm">View</button>
                        </span>
                    </div>
                    <div class="d-flex align-items-center osahan-post-header people-list">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="{{ url('assets/img/p12.png') }}" alt="">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold mr-2">
                            <div class="text-truncate">Richard Bell</div>
                            <div class="small text-gray-500">@Envato
                            </div>
                        </div>
                        <span class="ml-auto"><button type="button" class="btn btn-outline-danger btn-sm">View</button>
                        </span>
                    </div>
                </div>
                <div class="box-footer p-2 border-top">
                    <button type="button" class="btn btn-primary btn-block"> View all </button>
                </div>
            </div>

        </div>

        <div class="tab-pane fade d-lg-none right-side-small" id="menu-dish" role="tabpanel"
            aria-labelledby="menu-dish-tab">

        </div>
    </div>

</div>

{{-- Profile Edit Modal--}}
@include('vendor.components.profile-edit')

{{--Profile Image Edit Modal--}}
@include('vendor.components.profile-image-edit')

{{--Cover Image Edit Modal--}}
@include('vendor.components.cover-image-edit')

@endsection

@push('scripts')
<script>
    // Cropper.JS Initialize any crop by calling the crop function
    window.addEventListener("DOMContentLoaded", function () {
        // Initialize crop for profile image
        crop("avatar", "image", "input", "progress", "progress-bar", "alert", "modal", "change", "crop",
            "profile_image_update");

        // Initialize crop for cover image
        crop("cover", "cover-image", "cover-input", "progress", "progress-bar", "alert", "cover-modal",
            "cover-change", "cover-crop", "cover_image_update");
    });

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
                            } else {
                                setTimeout(function () {
                                    $progress.hide();
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

    // Open profile edit modal
    $("#profile-edit-btn").on('click', function () {
        $("#profile-edit-modal").modal('toggle');
    });

</script>
@endpush
