// Grab server url from script tag
server = document.currentScript.getAttribute("server");

// CSRF Token
_token = document.currentScript.getAttribute("token").trim();

$(document).ready(function () {
    // Load The Right Side when Document is Ready
    loadUserRight();

    // Load The Left Side when Document is Ready
    loadUserLeft();

    // Load user basket details
    getBasket();

    // Hide accordions on init
    hideAccordion();
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

/*********************************** Basket script */
// Load user basket
function getBasket() {
    let getUrl = `${server}/user/get-basket`;

    goGet(getUrl).then((res) => {
        if (res.basket_count == 0) {
            $("#basket-noti-dot").addClass('d-none');
        } else {
            $("#basket-noti-dot").html(res.basket_count);
            $("#head-count").html("(" + res.basket_count + " Items)");
            $("#basket-noti-dot").removeClass('d-none');
            $(".basket-container").html(res.basket_view);
        }
    }).catch((err) => {
        // spin('user-left-side');
    });
}

function toggleAccordion(e, element) {
    $(element).parent().parent().next().collapse('toggle');
    $('.collapse').collapse('hide');
}

function hideAccordion() {
    $('.collapse-hide').collapse('hide');
}

function deleteCartItem(basketId, orderType, itemPosition = null) {
    let url = `${server}/user/delete-basket`;
    let formData = new FormData();

    if (orderType == "simple") {
        formData.append('_token', _token);
        formData.append('basket_id', basketId);
        formData.append('order_type', orderType);
    } else {
        formData.append('_token', _token);
        formData.append('basket_id', basketId);
        formData.append('order_type', orderType);
        formData.append('item_position', itemPosition);
    }

    goPost(url, formData)
        .then(res => {

            if (handleFormRes(res)) {
                showAlert(true, res.message);

                // Load user basket details
                getBasket();
            }
        })
        .catch(err => {
            console.error(err);
        })
}
/*********************************** Basket script */



/*********************************** Quantity input script **************************************/
function clicked(e, element) {
    e.preventDefault();
    fieldName = $(element).attr('data-field');
    type = $(element).attr('data-type');
    var input = $(element).parent().parent().find('input');
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if (type == 'minus') {

            if (currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            }
            if (parseInt(input.val()) == input.attr('min')) {
                $(element).attr('disabled', true);
            }

        } else if (type == 'plus') {

            if (currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if (parseInt(input.val()) == input.attr('max')) {
                $(element).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
}

function focusin(e, element) {
    $(element).data('oldValue', $(element).val());
}

function change(e, element) {
    minValue = parseInt($(element).attr('min'));
    maxValue = parseInt($(element).attr('max'));
    valueCurrent = parseInt($(element).val());

    // Compute total amount and bind to order button. Also disable and enable order button
    bindQtyPrice(element);

    // Disable and enable details input field
    handleDetailInput(element);

    name = $(element).attr('name');
    if (valueCurrent >= minValue) {
        // $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
        $(element).prev().find('button').removeAttr('disabled');
    } else {
        alert('Sorry, the minimum value was reached');
        $(element).val($(element).data('oldValue'));
        $(element).attr('disabled', '');
    }


    if (valueCurrent <= maxValue) {
        // $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
        $(element).next().find('button').removeAttr('disabled');
    } else {
        alert('Sorry, the maximum value was reached');
        $(element).val($(this).data('oldValue'));
    }
}

function keydown(e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
        // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) ||
        // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
        // let it happen, don't do anything
        return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode >
            105)) {
        e.preventDefault();
    }
}


/****** Initiate price input field state ***************/
packCount = $("#price-type li").length;
prices = [];
for (let i = 0; i < packCount; i++) {
    prices[i] = 0;
}
/****** Initiate price input field state ***************/

// Function to compute total amount and bind to order button. Also disable and enable order button
function bindQtyPrice(element) {
    let index = $(element).parent().parent().parent().index();
    let price = Number($(element).parent().parent().prev().find('span').text().replace('₦', '').trim());
    let qty = $(element).val();
    let finalTotal = (price * qty);
    prices[index] = finalTotal;
    finalTotal = prices.reduce((a, b) => a + b);

    if (finalTotal < 1) {
        $("#final-price").text('₦' + String(finalTotal.toFixed(2)));
        $("#order-btn").attr('disabled', '');
    } else {
        $("#final-price").text('₦' + String(finalTotal.toFixed(2)));
        $("#order-btn").removeAttr('disabled');
    }
}

// Function to disable and enable details input field
function handleDetailInput(element) {
    valueCurrent = parseInt($(element).val());
    if (valueCurrent < 1) {
        $(element).parent().parent().prev().find('input').attr('disabled', '');
        $(element).attr('disabled', '');
    } else {
        $(element).parent().parent().prev().find('input').removeAttr('disabled');
        $(element).removeAttr('disabled');
    }
}
/*********************************** Quantity input script **************************************/
