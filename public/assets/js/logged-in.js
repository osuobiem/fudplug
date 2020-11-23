// Grab server url from script tag
server = document.currentScript.getAttribute("server");

// Like/Unlike a post
function likePost(post_id, likon) {
    // Animate Like
    $(likon).removeClass("animate__animated animate__pulse animate__faster");
    $(likon).addClass("animate__animated animate__heartBeat");

    likeCount = parseInt($(likon).attr("like-count"));

    doLike(likeCount, likon, post_id, true);

    url = `${server}/post/like/${post_id}`;

    goGet(url)
        .then((res) => {
            !res.success ? doUnlike(likeCount, likon, post_id) : null;
        })
        .catch((err) => {
            doUnlike(likeCount, likon, post_id);
        });
}

// Unlike a Post
function unlikePost(post_id, likon) {
    // Animate Dislike
    $(likon).removeClass("animate__animated animate__heartBeat");
    $(likon).addClass("animate__animated animate__pulse animate__faster");

    likeCount = parseInt($(likon).attr("like-count"));

    doUnlike(likeCount, likon, post_id, true);

    url = `${server}/post/unlike/${post_id}`;

    goGet(url)
        .then((res) => {
            !res.success ? doLike(likeCount, likon, post_id) : null;
        })
        .catch((err) => {
            doLike(likeCount, likon, post_id);
        });
}

// Like
function doLike(likeCount, likon, post_id, change = false) {
    $(likon).removeClass("la-heart-o");
    $(likon).addClass("la-heart");
    $(likon).attr("onclick", `unlikePost('${post_id}', this)`);

    if (change) {
        likeCount += 1;
    }

    $(likon).attr("like-count", likeCount);
    $($(likon).siblings()[0]).text(" " + likeCount);
}

// Unlike
function doUnlike(likeCount, likon, post_id, change = false) {
    $(likon).removeClass("la-heart");
    $(likon).addClass("la-heart-o");
    $(likon).attr("onclick", `likePost('${post_id}', this)`);

    if (change) {
        likeCount = likeCount == 0 ? 0 : likeCount - 1;
    }

    $(likon).attr("like-count", likeCount);
    $($(likon).siblings()[0]).text(" " + likeCount);
}

// Delete Comment
function deleteComment(id) {
    swal({
        title: "Are you sure?",
        buttons: ["Cancel", "Delete"],
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            doDelete();
        }
    });

    // Process Comment Delete
    function doDelete() {
        url = `${server}/comment/delete/${id}`;
        goGet(url)
            .then((res) => {
                if (res.success) {
                    popComment();
                    showAlert(true, res.message);
                } else {
                    showAlert(false, res.message);
                }
            })
            .catch((err) => {
                showAlert(false, "Oops! Something's not right. Try Again");
            });
    }

    // Remove comment from container
    function popComment() {
        $("#comment__" + id).addClass("animate__animated animate__fadeOutDown");

        setTimeout(() => {
            $("#comment__" + id).remove();
        }, 1000);
    }
}

// Scroll to top
function scrollToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;

    $("#see-l-posts-btn").addClass("d-none");
}
