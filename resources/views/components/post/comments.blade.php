@php
$type = isset($_GET['type']) ? $_GET['type'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
@endphp

<div class="dropup-container comments-container animate__animated d-none" onclick="closeComments()">
    <div class="dropup-inner comments-inner animate__animated" style="height: 99%">

        <ul class="nav nav-justified osahan-line-tab" style="box-shadow: 0 5px 10px 0 #00000061">
            <li class="nav-item text-left">
                <a class="nav-link active comments-top-a dropup-top-a d-flex" style="padding: 0 !important">
                    <span class="ml-2 py-2"> <i class="la la-comments la-lg"></i> Comments</span>
                    <div class="text-right">
                        <i class="la la-times la-lg comments-top-ico dropup-top-ico" onclick="closeComments()"></i>
                    </div>
                </a>
            </li>
        </ul>

        <div class="pb-2 pt-3" id="comments-holder">

            <div class="justify-content-center text-center w-100 pb-2 box p-2 mt-4">
                <p><strong>Loading Comments</strong></p>
                <div class="spinner-border spinner-border-sm btn-pr p-2" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

        </div>

        <form id="comment-form">
            <div class="p-3 pt-2 d-flex align-items-center w-100 comments-input-cont bg-white">
                <div class="post-textarea-cont w-100" id="comment-form">
                    @csrf
                    <textarea placeholder="What do you think?..."
                        class="form-control border-0 p-0 shadow-none post-input" required id="comment-textarea"
                        name="comment_content"></textarea>

                    <i class="la la-paper-plane la-lg comment-post-ico" id="comment-txt" onclick="submitComment()"></i>
                    <button class="btn btn-primary btn-sm" id="comment-spinner" style="display: none;">
                        <div class="spinner-border spinner-border-sm btn-pr p-2" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </button>

                    <small class="text-danger error-message" id="comment_content"></small>
                </div>
            </div>
        </form>

        <div>
            <button class="btn btn-primary animate__animated animate__fadeInUp d-none" onclick="scrollToNewComments()"
                id="see-n-comms-btn">See New Comments <i class="la la-arrow-down"></i></button>
        </div>

    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#comment-textarea").emojioneArea({
                pickerPosition: "top"
            });

            $('#comment-form').submit(el => {
                el.preventDefault()

                createComment(el)
            })

            type = `{{ $type }}`
            id = `{{ $id }}`
            if (type == 'like' || type == 'comment') {
                openComments(id, type)
            }
        });

        // Fetch Comments
        function fetchComments(post_id, type = 'comment') {
            post = post_id

            url = `{{ url('comment/get') }}/${post_id}`
            goGet(url)
                .then(res => {
                    $('#comments-holder').html($.parseHTML(res))
                    comments_holder = document.getElementById("comments-holder");
                    comments_holder.scrollTop = 0;

                    if(type == 'comment') {
                        setTimeout(() => {
                            $("#comments-holder").animate({
                                scrollTop: comments_holder.scrollHeight
                            }, "slow")
                        }, 1000)
                    }
                })
        }

        // Fetch Comments
        function fetchMoreComments(post_id, from) {
            url = `{{ url('comment/get') }}/${post_id}/${from}`
            goGet(url)
                .then(res => {
                    comments_holder = document.getElementById("comments-holder");
                    h = comments_holder.scrollHeight;

                    $('.more-comments').remove()

                    $('#comments-below-post').prepend(res)
                    comments_holder.scrollTop = comments_holder.scrollHeight - h;
                })
        }

        // Submit Comment
        function submitComment() {
            $('#comment-form').submit()
        }

        // Create Comment
        function createComment(el) {
            spin('comment')

            url = `{{ url('comment/create') }}/${post}`;
            data = new FormData(el.target)

            goPost(url, data)
                .then(res => {
                    if (handleFormRes(res)) {
                        spin('comment')
                        // Append new comment
                        $('#no-comment').html() === undefined ?
                            $('#comments-below-post').append($.parseHTML(res)) :
                            $('#comments-below-post').html(res)

                        // Scroll to bottom
                        comments_holder = document.getElementById("comments-holder");
                        $("#comments-holder").animate({
                            scrollTop: comments_holder.scrollHeight
                        }, "slow");

                        // Clear Textarea
                        [...$('.emojionearea-editor')].forEach(el => {
                            $(el).attr('placeholder') == "What do you think?..." ?
                                $(el).text('') : null;
                        })
                    } else {
                        spin('comment')
                    }
                })
                .catch(() => {
                    spin('comment')
                    showAlert(false, "Oops! Something's not right. Try again");
                })
        }

    </script>
@endpush
