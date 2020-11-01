// Grab server url from script tag
server = document.currentScript.getAttribute("server");

$(document).ready(function () {
    // Load The Right Side when Document is Ready
    loadUserRight();
});

// Load User Right Side (User Profile)
function loadUserRight(loadEdit = true) {
    spin('user-right-side');
    // Populate dishes tab on page load
    let getUrl = `${server}/user/profile`;

    goGet(getUrl).then((res) => {
        if (window.matchMedia("(max-width: 767px)").matches) {
            // The viewport is less than 768 pixels wide (mobile device)
            $("#user-right-side-small").html(res);
        } else {
            // The viewport is at least 768 pixels wide (Desktop or tablet)
            spin('user-right-side');
            $("#user-right-side-large").html(res);
        }

        // Load Edit Modal Afer Loading Right Side
        if (loadEdit) {
            loadEditModal();
        }
    }).catch((err) => {
        spin('user-right-side');
    });
}

// Load User Profile dit Modal
function loadEditModal() {
    // spin('user-right-side');
    // Populate dishes tab on page load
    let getUrl = `${server}/user/profile-edit`;

    goGet(getUrl).then((res) => {
        $("#edit-modal-container").html(res);
    }).catch((err) => {
        //spin('user-right-side');
    });
}
