<!-- Post Modal Launcher -->
<div class="post-modal-init">
    <div class="box shadow-sm border rounded bg-white mb-3 osahan-share-post">
        <ul class="nav nav-justified border-bottom osahan-line-tab" id="myTab" role="tablist">
            <li class="nav-item text-left">
                <a class="nav-link active" style="padding: 1rem .5rem !important" id="home-tab" data-toggle="tab"
                    role="tab" aria-controls="home" aria-selected="true"><i class="la la-utensil-spoon la-lg"></i> What
                    did you cook today?
                </a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="p-3 pt-2 d-flex align-items-center w-100">
                    <div class="post-textarea-cont-2 w-100">
                        <textarea placeholder="Post something delicious..." id="dummy-post-area" disabled
                            class="form-control border-0 p-0 shadow-none" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Post Modal -->
<div class="post-modal animate__animated d-none">
    <div class="box shadow-sm border rounded bg-white mb-3 osahan-share-post">
        <ul class="nav nav-justified border-bottom osahan-line-tab" id="myTab" role="tablist">
            <li class="nav-item text-left">
                <a class="nav-link active" style="padding: 1rem .5rem !important" id="home-tab" data-toggle="tab"
                    role="tab" aria-controls="home" aria-selected="true"><i class="la la-utensil-spoon la-lg"></i> What
                    did you cook today?
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
                    <div class="p-3 pt-2 d-flex align-items-center w-100">
                        <div class="post-textarea-cont w-100">
                            <textarea placeholder="Post something delicious..."
                                class="form-control border-0 p-0 shadow-none post-input" required name="content"
                                rows="5" id="post-textarea" name="content" autofocus="true"></textarea>
                            <small class="text-danger error-message" id="content"></small>
                        </div>
                    </div>

                    <div class="py-2 px-3" id="tag-list">
                    </div>
                </div>
            </div>

            <input type="file" accept="image/*" multiple id="image-1" class="d-none" onchange="fill(this)">
            <input type="file" accept="image/*" multiple id="image-2" class="d-none" onchange="fill(this)">
            <input type="file" accept="image/*" multiple id="image-3" class="d-none" onchange="fill(this)">
            <input type="file" accept="image/*" multiple id="image-4" class="d-none" onchange="fill(this)">
            <div id="vid-in">
                <input type="file" accept="video/*" id="video-file" class="d-none" onchange="fillVideo(this)">
            </div>

            <!-- Media Container -->
            <div class="post-modal-media-container post-media-container p-3 d-none" id="post-media-container">
            </div>
            <div class="post-modal-media-container post-media-container p-3 d-none" id="post-video-container">
            </div>
            <div id="video-spinner" class="justify-content-center text-center w-100 pb-2 d-none">
                <p><strong>Loading Video...</strong></p>
                <div class="spinner-border spinner-border-sm btn-pr p-2" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <!-- Post Modal Foot -->
            <div class="border-top p-3 d-flex align-items-center">
                <div class="mr-auto" id="media-input-div">
                    <a id="pick-image" class="post-ico" title="Pick photos"><i
                            class="la la-camera-retro la-2x p-1 icon-hover"></i></a>
                    <a id="pick-video" class="ml-2 post-ico" title="Pick video"><i
                            class="la la-video la-2x p-1 icon-hover"></i></a>
                    <a id="tag-to-post" onclick="showTags(true)" class="ml-2 post-ico" title="Tag item from menu"><i
                            class="la la-tag la-2x p-1 icon-hover"></i></a>
                </div>
                <button type="button" class="btn btn-outline-danger px-5 btn-lg ml-auto" onclick="submitPost()"
                    type="submit" id="post-btn">
                    <span id="post-txt">Post</span>

                    <div class="spinner-border spinner-border-sm btn-pr" id="post-spinner" style="display: none;"
                        role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </button>
            </div>

            <div class="m-2 d-none animate__animated animate__fadeIn" id="tag-menu">
                @if (!empty($tag_items))
                    <div class="d-flex p-2">
                        <div><strong class="text-dark">Tag Menu Items to this post</strong></div>
                    </div>

                    <div id="tag-menu-items">
                        @foreach ($tag_items as $item)
                            @php
                                $tag_list_item = str_replace(' ', '_', strtolower($item->title));
                                $photo = Storage::url('vendor/dish/' . $item->image);
                            @endphp
                            <div class="p-2 d-flex align-items-center"
                                onclick="addTag(this, '{{ $item->id }}', '{{ $tag_list_item }}')"
                                title="Tag {{ $item->title }}">
                                <div class="mr-2">
                                    <div class="item-photo-sm" style="background: url('{{ $photo }}')"></div>
                                </div>

                                <div><span class="text-dark">{{ $item->title }}</span></div>
                                <div class="ml-auto"><i class="la la-tag la-lg tag-icon"></i></div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-3"><span>Your menu is empty!</span></div>
                @endif
            </div>

        </form>
        <!--/ Post Form -->
    </div>

    <canvas id="canvas" class="d-none"></canvas>
</div>

@push('scripts')
    <script>
        let images = {};
        let video = {};
        let videoThumb = '';
        tags = [];

        $(document).ready(function() {
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
                } else {
                    $('.floating-post-btn').removeClass('animate__fadeInUp')
                    $('.floating-post-btn').addClass('animate__fadeOutDown')
                }
                if (window.scrollY >= 130) {
                    $('.floating-post-btn-sm').removeClass('d-none animate__fadeOutRight')
                    $('.floating-post-btn-sm').addClass('animate__fadeInRight')
                } else {
                    $('.floating-post-btn-sm').removeClass('animate__fadeInRight')
                    $('.floating-post-btn-sm').addClass('animate__fadeOutRight')
                }
            })
            imageCounter = 1;
            $('#pick-image').click(() => {
                if (Object.keys(video).length > 0) {
                    showAlert(false, "Remove video first")
                } else {
                    if (imageCounter >= 5) {
                        showAlert(false, "You can't upload more than 4 images")
                    } else {
                        $('#image-' + imageCounter).click()
                    }
                }
            })
            $('#pick-video').click(() => {
                if (imageCounter > 1) {
                    showAlert(false, "Remove photo(s) first")
                } else {
                    if (Object.keys(video).length > 0) {
                        showAlert(false, "You can't upload more than 1 video")
                    } else {
                        $('#video-file').click()
                    }
                }
            })
        });
        // Send Post
        async function sendPost(el) {
            el.preventDefault()

            spin('post')
            liner();
            closePostModal()

            let url = `{{ url('post/create') }}`;
            let data = new FormData(el.target)

            // Attach images to form data
            if (Object.keys(images).length > 0) {
                for (image in images) {
                    compressedimage = compressImg(images[image])
                    data.append('images[]', await compressedimage)
                }
            }

            // Attach video to form data
            if (video.file) {
                capture()
                data.append('video', video.file);
                data.append('thumbnail', videoThumb);
            }

            // Add tags
            tags.forEach(tag => {
                data.append('tags[]', tag)
            })

            goPost(url, data)
                .then(res => {
                    spin('post')
                    liner(false)

                    if (handleFormRes(res)) {
                        showAlert(true, 'Post Sent Successfully!');
                        refreshPostForm();
                    }
                })
                .catch(err => {
                    spin('post')
                    liner(false)

                    handleFormRes(err);
                })
        }

        // Reload Post Form
        function refreshPostForm() {
            $('#close-post').click();

            removePostImg(false, true)
            removePostVid()
            $('.emojionearea-editor').text('')
            $('.emojionearea-editor').attr('value', '')
            document.getElementsByName('content').forEach(v => {
                v.value = ''
            })

            tags = [];
            $('#tag-list').html('');
            $('.tag-icon-active').addClass('tag-icon');
            $('.tag-icon-active').removeClass('tag-icon-active');

            $('#tag-to-post').attr('onclick') == 'showTags(false)' ? $('#tag-to-post').click() : null
        }

        // Fill Picked Image in Div
        function fill(input) {
            sendErr = false;
            if (input.files) {
                hideMediaInputs();
                [...input.files].forEach((file, ind) => {
                    if (imageCounter < 5) {
                        if (file.size > 52428800) {
                            showAlert(false, "Image size must not be more than 50MB");
                            imageCounter -= 1
                            hideMediaInputs(false);
                        } else if (file.type.split("/")[0] != "image") {
                            showAlert(false, "The file is not an image");
                            imageCounter -= 1
                            hideMediaInputs(false);
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
                            img.innerHTML =
                                `<span class="pmmc-ix" onclick="removePostImg('${pid}')"><i class="la la-times la-lg"></i></span>`;
                            images[pid] = file
                            hideMediaInputs(false);
                            $('#post-media-container').removeClass('d-none')
                            $('#post-video-container').addClass('d-none')
                        }
                    } else {
                        sendErr = true;
                        hideMediaInputs(false);
                    }
                    imageCounter++
                })
                sendErr ? showAlert(false, "You can't upload more than 4 images") : null
                arrangeImages()
                hideMediaInputs(false);
            }
        }

        // Fill Picked Video in Div
        function fillVideo(input) {
            $('#video-spinner').removeClass('d-none')
            if (input.files) {
                if (input.files.length > 1) {
                    showAlert(false, "Only 1 video upload allowed");
                }

                hideMediaInputs();
                [...input.files].forEach((file, ind) => {
                    if (file.size > 262144000) {
                        $('#video-spinner').addClass('d-none')
                        showAlert(false, "Video size must not be more than 250MB");
                        hideMediaInputs(false);
                    } else if (file.type.split("/")[0] != "video") {
                        $('#video-spinner').addClass('d-none')
                        showAlert(false, "The file is not a video");
                        hideMediaInputs(false);
                    } else {
                        var vid = document.createElement('video')

                        video_url = URL.createObjectURL(file)

                        vid.setAttribute(
                            "src",
                            video_url
                        )
                        setTimeout(() => {
                            duration = vid.duration
                            if (duration >= 151) {
                                $('#video-spinner').addClass('d-none')
                                showAlert(false,
                                    "Video cannot be longer than 1min 30secs. Please trim the video and try again."
                                );
                                hideMediaInputs(false);
                            } else {
                                vid.setAttribute('controls', 'controls')
                                vid.setAttribute('id', 'video-loaded')

                                video = {
                                    'file': file
                                }
                                cont = document.getElementById('post-video-container');
                                cont.innerHTML =
                                    `<span class="pmmc-ixv" onclick="removePostVid()"><i class="la la-times la-lg"></i></span>`;
                                cont.prepend(vid)

                                $('#video-spinner').addClass('d-none')


                                $('#post-video-container').removeClass('d-none')
                                $('#post-media-container').addClass('d-none')

                                hideMediaInputs(false)
                            }
                        }, 1000)
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
        function removePostImg(id = false, all = false) {
            $('#' + id).remove()
            delete images[id]
            imageCounter = $('.pmmc-i').length + 1
            arrangeImages()

            if (imageCounter == 1) {
                $('#post-media-container').addClass('d-none')
            }

            // Remove all images
            if (all) {
                images = {};
                imageCounter = 1;
                $('#post-media-container').html('')
                $('#post-media-container').addClass('d-none')
            }
        }
        // Remove Post Video
        function removePostVid() {
            $('#post-video-container').html('')
            video = {}
            $('#vid-in').html(
                `<input type="file" accept="video/*" multiple id="video-file" class="d-none" onchange="fillVideo(this)">`
            );
            $('#post-video-container').addClass('d-none')
        }
        // Submit Post
        function submitPost() {
            $('#post-form').submit();
        }

        // Hide/Show Post Media Inputs
        function hideMediaInputs(hide = true) {
            hide ? $('#media-input-div').addClass('d-none') : $('#media-input-div').removeClass('d-none');
        }

        // Capture Thumbnail from video
        function capture() {
            var canvas = document.getElementById('canvas');
            var video = document.getElementById('video-loaded');
            canvas.getContext('2d').drawImage(video, 0, 0, video.clientWidth, video.clientHeight);

            videoThumb = canvas.toDataURL();
        }

        // Toggle Post Sending Line
        function liner(show = true) {
            if (screen.width > 768) {
                show ? $('#send-post-liner-lg').removeClass('d-none') : $('#send-post-liner-lg').addClass('d-none')
            } else {
                show ? $('#send-post-liner-sm').removeClass('d-none') : $('#send-post-liner-sm').addClass('d-none')
            }
        }

        // Toggle tag menu
        function showTags(show) {
            if (show) {
                $('#tag-menu').removeClass('d-none');
                $('#tag-to-post').attr('onclick', 'showTags(false)')
            } else {
                $('#tag-to-post').attr('onclick', 'showTags(true)')
                $('#tag-menu').addClass('d-none');
            }
        }

        // Add tag
        function addTag(el, item_id, tag_list_item) {
            icon = $(el).find('.tag-icon')
            $(icon).removeClass('tag-icon')
            $(icon).addClass('tag-icon-active')

            $(el).attr('onclick', `removeTag(this, '${item_id}', '${tag_list_item}')`)

            $('#tag-list').append(`
                        <span class="tag-list-item" id="tli-${item_id}">${tag_list_item}</span>
                    `);

            tags.push(item_id)
        }

        // Remove tag
        function removeTag(el, item_id, tag_list_item) {
            icon = $(el).find('.tag-icon-active')
            $(icon).removeClass('tag-icon-active')
            $(icon).addClass('tag-icon')

            $(el).attr('onclick', `addTag(this, '${item_id}', '${tag_list_item}')`)

            $('#tli-' + item_id).remove()

            tags.splice(tags.indexOf(item_id), 1)
        }

    </script>
@endpush
