// Grab server url from script tag
server = document.currentScript.getAttribute("server");

$(document).ready(function () {
    // Load The Right Side when Document is Ready
    loadUserRight();
});

// Load User Right Side (User Profile) For Mobile
function loadUserRight(loadEdit = true, mobileEdit = false) {
    spin('user-right-side');

    if (window.matchMedia("(max-width: 767px)").matches) { // The viewport is less than 768 pixels wide (mobile device)
        let getUrl = `${server}/user/profile/mobile`;

        goGet(getUrl).then((res) => {
            $("#user-right-side-small").html(res);
            // Load Edit Modal Afer Loading Right Side
            if (loadEdit) {
                loadEditModal();
            }

            // Refresh and Show Prrofile Modal After Editing User Profile
            if (mobileEdit) {
                $("#user-profile-modal").modal('show');
            }
        }).catch((err) => {
            spin('user-right-side');
        });
    } else { // The viewport is at least 768 pixels wide (Desktop or tablet)
        let getUrl = `${server}/user/profile/desktop`;

        goGet(getUrl).then((res) => {
            spin('user-right-side');
            $("#user-right-side-large").html(res);

            // Load Edit Modal Afer Loading Right Side
            if (loadEdit) {
                loadEditModal();
            }
        }).catch((err) => {
            spin('user-right-side');
        });
    }
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
