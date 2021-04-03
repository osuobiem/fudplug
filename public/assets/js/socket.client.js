// Initialize Socket Client
function initIO(server, username, area = '') {
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
        if (data.area == area) {
            $(`#post-comm-inner-${data.postId}`).html(
                `&nbsp;${data.commentsCount}`
            );
        }
    });

    // Listen for new comment event
    socket.on("new-comment", (data) => {
        if (data.area == area && commentModalOpen && data.commentor != socket.id && data.postId == openCommentsPost) {
            // Append new comment
            $("#no-comment").html() === undefined
                ? $("#comments-holder").append($.parseHTML(data.newComment))
                : $("#comments-holder").html(data.newComment);

            // Scroll to bottom
            comments_holder = document.getElementById("comments-holder");

            if(comments_holder.scrollHeight - comments_holder.scrollTop == 410) {
                comments_holder.scrollTop = comments_holder.scrollHeight;
            }
            else if(comments_holder.scrollHeight - comments_holder.clientHeight > 75) {
                $('#see-n-comms-btn').removeClass('d-none');
            }
        }

        // Clear text area after new comment has been pushed to container
        if(data.commentor == socket.id) {
            // Clear Textarea
            [...$(".emojionearea-editor")].forEach((el) => {
                $(el).attr("placeholder") == "What do you think?..."
                    ? $(el).text("")
                    : null;
            });
        }
    })

    // Listen for comment deletion
    socket.on("delete-comment", (data) => {
        if (data.area == area && commentModalOpen && data.commentor != socket.id && data.postId == openCommentsPost) {
            popComment(data.commentId)
        }
    })

    // Listen for new notification
    socket.on("notify", (data) => {
        if (data.owner == socket.id) {
            ncounter = parseInt($('#noti-dot').text())
            $('#notification-container').prepend(data.content)
            $('#noti-dot').text(ncounter+1)
            $('#noti-dot').removeClass('d-none')

            ncounter = parseInt($('#mob-noti-dot').text())
            $('#mob-noti-dot').text(ncounter+1)
            $('#mob-noti-dot').removeClass('d-none')

            notiSound.play()
            $('#m-a-a-r').removeClass('d-none')

            sendPush(data.content_nmu)
        }
    })

    // Listen for post deletion
    socket.on("delete-post", (data) => {
        popPost(data.postId)
    })
}
