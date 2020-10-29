// Grab server url from script tag
server = document.currentScript.getAttribute("server");

$(document).ready(function () {
    // Variable to Hold Right Side Bar Active Tab
    let activeTab = '1';

    // Load The Right Side when Document is Ready
    loadRight(activeTab);
});

// Load Right Side (Vendor Dish & Menu)
function loadRight(activeTab) {
    spin('right-side')
    // Populate dishes tab on page load
    let getUrl = `${server}/vendor/dish`;

    goGet(getUrl).then((res) => {
        spin('right-side')
        if (window.matchMedia("(max-width: 767px)").matches) {
            // The viewport is less than 768 pixels wide (mobile device)
            $("#dish-menu").remove();
            $(".right-side-large").empty();
            $(".right-side-small").append(res);
            $(`#rightTab li:nth-child(${activeTab}) a`).tab('show');
        } else {
            // The viewport is at least 768 pixels wide (Desktop or tablet)
            $("#dish-menu").remove();
            $(".right-side-small").empty();
            $(".right-side-large").append(res);
            $(`#rightTab li:nth-child(${activeTab}) a`).tab('show');
        }
    }).catch((err) => {
        spin('right-side')
    });
}

// Load Menu Modal Data
function loadMenuModal() {
    let getUrl = `${server}/vendor/menu`;
    goGet(getUrl).then((res) => {
        $("#menu-modal-holder").empty();
        $("#menu-modal-holder").html(res);
        $("#menu-update-modal").modal('show');
    }).catch((err) => {
        console.error(err);
    });
}

// Function Keeps Track of Active Tab
function track(active = '1') {
    activeTab = active;
}
