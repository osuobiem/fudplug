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
        data.area == area
            ? $("#in-post-container").prepend($.parseHTML(data.markup))
            : null;
    });
}
