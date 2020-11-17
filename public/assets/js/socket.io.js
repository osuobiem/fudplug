// Initialize Socket Client
function initIO(server, username, area) {
    const socket = io(server);

    // Listen for connection event
    socket.on("connect", () => {
        socket.emit("save-id", username);
    });

    // Listen for like count event
    socket.on("like-count", (data) => {
        if (data.area == area) {
            $(`#post-likes-${data.postId}`).attr("like-count", data.likesCount);
            $(`#post-likes-inner-${data.postId}`).html(
                `&nbsp;${data.likesCount}`
            );
        }
    });

    // Listen for new post event
    socket.on("new-post", (data) => {
        if (data.area == area) {
            $("#in-post-container").prepend($.parseHTML(data.markup));

            if (
                document.body.scrollTop > 150 ||
                document.documentElement.scrollTop > 150
            ) {
                $("#see-l-posts-btn").removeClass("d-none");

                setTimeout(() => {
                    $("#see-l-posts-btn").addClass("d-none");
                }, 10000);
            }
        }
    });

    // Listen for comment count event
    socket.on("comment-count", (data) => {
        console.log(data)
        if (data.area == area) {
            $(`#post-comm-inner-${data.postId}`).html(
                `&nbsp;${data.commentsCount}`
            );
        }
    });
}
