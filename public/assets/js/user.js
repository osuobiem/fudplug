// Grab server url from script tag
server = document.currentScript.getAttribute("server");

$(document).ready(function () {
    // Load The Right Side when Document is Ready
    loadUserRight();

    // Load The Left Side when Document is Ready
    loadUserLeft();

    // // Load "All Vendors" Modal When Document Is Ready
    // allVendors();
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

// Load Regular Order Modal
function loadRegOrderModal(dishId) {
    // spin('user-right-side');
    // Populate regular-order modalcontainer
    let getUrl = `${server}/user/order-details`;
    getUrl += '/' + dishId;

    goGet(getUrl).then((res) => {
        $("#regular-order-container").html(res);
        $("#regular-order-modal").modal('show');
    }).catch((err) => {
        //spin('user-right-side');
    });
}

// Load User Left Side (Nearby Vendors)
function loadUserLeft() {
    spin('user-left-side');

    let getUrl = `${server}/user/get-vendors`;

    goGet(getUrl).then((res) => {
        $("#user-left-side").html(res);
    }).catch((err) => {
        spin('user-left-side');
    });
}


// Load "All Vendors" Modal
// function allVendors() {

//     let getUrl = `${server}/user/all-vendors`;

//     goGet(getUrl).then((res) => {
//         $("#all-vendors").html(res);
//     }).catch((err) => {
//         //spin('user-left-side');
//     });
// }
