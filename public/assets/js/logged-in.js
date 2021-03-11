// Grab server url from script tag
server = document.currentScript.getAttribute("server");
notiSound = new Audio(`${server}/assets/ding.mp3`)

$(document).ready(function () {
    getNotifications()
});

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

// Spy for open comment modal
commentModalOpen = false;
openCommentsPost = null;

// Open Comments Modal
function openComments(post_id) {
    $("body").addClass("modal-open");
    $(".comments-container").removeClass("d-none");

    $(".comments-inner").addClass("animate__fadeIn");
    $(".comments-container").addClass("animate__fadeIn");

    $(".comments-inner").removeClass("animate__fadeOut");
    $(".comments-container").removeClass("animate__fadeOut");

    $('#comment-textarea')[0].emojioneArea.setFocus()

    commentModalOpen = true;
    openCommentsPost = post_id

    fetchComments(post_id);
}

// Close Comments Modal
function closeComments() {
    $("body").removeClass("modal-open");
    $(".comments-inner").removeClass("animate__fadeIn");
    $(".comments-container").removeClass("animate__fadeIn");

    $(".comments-inner").addClass("animate__fadeOut");
    $(".comments-container").addClass("animate__fadeOut");

    commentModalOpen = false;
    openCommentsPost = null

    setTimeout(() => {
        $(".comments-container").addClass("d-none");
    }, 500);
}

// Delete Comment
function deleteComment(id) {
    swal({
        title: "Are you sure?",
        buttons: ["Cancel", "Delete"],
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            doDelete(id);
        }
    });
}

// Process Comment Delete
function doDelete(id) {
    url = `${server}/comment/delete/${id}`;
    goGet(url)
        .then((res) => {
            if (res.success) {
                popComment(id);
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
function popComment(id) {
    $("#comment__" + id).addClass("animate__animated animate__fadeOutDown");

    setTimeout(() => {
        $("#comment__" + id).remove();
    }, 1000);
}

// Scroll to top
function scrollToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;

    $("#see-l-posts-btn").addClass("d-none");
}

// Get notifications
function getNotifications(from = 0) {
    let url = `${server}/notification/get/${from}`

    goGet(url)
        .then(res => {
            if (res.length > 0) {
                from == 0 ? $('#notification-container').html(res) : $('#notification-container').append(res)
            }
        })
}

// Get more notifications
function getMoreNotifications() {
    if (spyBottom('notification-container', 300)) {
        from = $('#noti-from').text()
        getNotifications(from)
    }
}

// Mark notification as read
function markAsRead(id, el) {
    let url = `${server}/notification/mark-as-read/${id}`

    goGet(url)
        .then(res => {
            $(el).parent().parent().removeClass('notification-card-u')
            $(el).parent().parent().addClass('notification-card-r')

            $(el).parent().parent().html(res)
        })
}

// Mark all notifications as read
function markAllAsRead() {
    let url = `${server}/notification/mark-as-read`

    goGet(url)
        .then(res => {
            [...$('.notification-card-u')].forEach(el => {
                $(el).removeClass('notification-card-u')
                $(el).addClass('notification-card-r')

                $($(el).children()[1]).removeClass('col-10')
                $($(el).children()[1]).addClass('col-11')

                $($(el).children()[2]).remove()
            })
            $('#m-a-a-r').addClass('d-none')
        })
}

// Clear NViewed
function clearNViewed() {
    let url = `${server}/notification/clear-nviewed`

    goGet(url)
        .then(res => {
            setTimeout(() => {
                $('#noti-dot').text(0)
                $('#noti-dot').addClass('d-none')
            }, 1500)
        })
}

// Open Mobile Notification Dropup Modal
function openMND() {
    $("body").addClass("modal-open");
    $(".mnd-container").removeClass("d-none");

    $(".mnd-inner").addClass("animate__fadeIn");
    $(".mnd-container").addClass("animate__fadeIn");

    $(".mnd-inner").removeClass("animate__fadeOut");
    $(".mnd-container").removeClass("animate__fadeOut");

    mndModalOpen = true;
}

// Close Mobile Notification Dropup Modal
function closeMND() {
    $("body").removeClass("modal-open");
    $(".mnd-inner").removeClass("animate__fadeIn");
    $(".mnd-container").removeClass("animate__fadeIn");

    $(".mnd-inner").addClass("animate__fadeOut");
    $(".mnd-container").addClass("animate__fadeOut");

    setTimeout(() => {
        $(".mnd-container").addClass("d-none");
    }, 500);
}

// Open Orders Dropup Modal
function openOrders() {
    $("body").addClass("modal-open");
    $(".order-container").removeClass("d-none");

    $(".order-inner").addClass("animate__fadeIn");
    $(".order-container").addClass("animate__fadeIn");

    $(".order-inner").removeClass("animate__fadeOut");
    $(".order-container").removeClass("animate__fadeOut");

    // Populate order DIV for mobile
    getOrder();
}

// Close Orders Dropup Modal
function closeOrders() {
    $("body").removeClass("modal-open");
    $(".order-inner").removeClass("animate__fadeIn");
    $(".order-container").removeClass("animate__fadeIn");

    $(".order-inner").addClass("animate__fadeOut");
    $(".order-container").addClass("animate__fadeOut");

    setTimeout(() => {
        $(".order-container").addClass("d-none");
    }, 500);
}

// Open Basket Dropup Modal
function openBasket() {
    $("body").addClass("modal-open");
    $(".bas-container").removeClass("d-none");

    $(".bas-inner").addClass("animate__fadeIn");
    $(".bas-container").addClass("animate__fadeIn");

    $(".bas-inner").removeClass("animate__fadeOut");
    $(".bas-container").removeClass("animate__fadeOut");
}

// Close Basket Dropup Modal
function closeBasket() {
    $("body").removeClass("modal-open");
    $(".bas-inner").removeClass("animate__fadeIn");
    $(".bas-container").removeClass("animate__fadeIn");

    $(".bas-inner").addClass("animate__fadeOut");
    $(".bas-container").addClass("animate__fadeOut");

    setTimeout(() => {
        $(".bas-container").addClass("d-none");
    }, 500);
}

// Compress image
function compressImg(image) {
    const options = {
        maxSizeMB: 0.5,
        maxWidthOrHeight: 1920,
        useWebWorker: true
    }

    return imageCompression(image, options);
}
