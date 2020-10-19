// Grab server url from script tag
server = document.currentScript.getAttribute("server");

$(document).ready(function () {
    // Variable to Hold Right Side Bar Active Tab
    let activeTab = "1";

    // Load The Right Side when Document is Ready
    loadRight(activeTab);
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

// Load Right Side (Vendor Dish & Menu)
function loadRight(activeTab) {
    spin("right-side");
    // Populate dishes tab on page load
    let getUrl = `${server}/vendor/dish`;

    goGet(getUrl)
        .then((res) => {
            spin("right-side");
            if (window.matchMedia("(max-width: 767px)").matches) {
                // The viewport is less than 768 pixels wide (mobile device)
                $("#dish-menu").remove();
                $(".right-side-large").empty();
                $(".right-side-small").append(res);
                $(`#rightTab li:nth-child(${activeTab}) a`).tab("show");
            } else {
                // The viewport is at least 768 pixels wide (Desktop or tablet)
                $("#dish-menu").remove();
                $(".right-side-small").empty();
                $(".right-side-large").append(res);
                $(`#rightTab li:nth-child(${activeTab}) a`).tab("show");
            }
        })
        .catch((err) => {
            spin("right-side");
        });
}

// Load Menu Modal Data
function loadMenuModal() {
    let getUrl = `${server}/vendor/menu`;
    goGet(getUrl)
        .then((res) => {
            $("#menu-modal-holder").empty();
            $("#menu-modal-holder").html(res);
            $("#menu-update-modal").modal("show");
        })
        .catch((err) => {
            console.error(err);
        });
}

// Function Keeps Track of Active Tab
function track(active = "1") {
    activeTab = active;
}
