// Initialize Socket Client
function initIO(server, username) {
    const socket = io(server);

    // Listen for connection event
    socket.on("connect", () => {
        socket.emit("save-id", username);
    });
}
