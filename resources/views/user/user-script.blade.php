<script>
    // Grab server url from script tag
    server = "{{url('')}}";

    // CSRF Token
    _token = "{{csrf_token()}}";

    // Object to hold pagination state for basket and orders
    var paginate = {
        basketPage: 1,
        orderPage: 1,
        orderType: "",
    }

    // Rating state variable
    @if(isset($rating_data))
    let rating = "{{round($rating_data['total_rating']) }}";
    let ratingState = "{{json_encode($rating_data['user_rating'])}}";
    @endif

    // Initiate regular order-specific price input field state
    packCount = $("#price-type li").length;
    var prices = [];
    for (let i = 0; i < packCount; i++) {
        prices[i] = 0;
    }

    // Initiate bulk order-specific price input field state
    bulkPackCount = $("#bulk-price-type li").length;
    var bulkPrices = [];
    for (let i = 0; i < bulkPackCount; i++) {
        bulkPrices[i] = 0;
    }

    $(document).ready(function () {
        // Load The Right Side when Document is Ready
        loadUserRight();

        // Load The Left Side when Document is Ready
        loadUserLeft();

        // Load user basket details
        getBasket(1);

        // Hide accordions on init
        hideAccordion();

        // Fetch user orders
        getOrder(1);
    });

    // Open user profile modal
    $("#user-profile-btn").on('click', function () {
        $("#user-profile-modal").modal('toggle');
    });


    // Load User Right Side (User Profile) For Mobile
    function loadUserRight(loadEdit = true, mobileEdit = false) {
        spin('user-right-side');

        if (window.matchMedia("(max-width: 767px)")
            .matches) { // The viewport is less than 768 pixels wide (mobile device)
            let getUrl = `${server}/user/profile/mobile`;

            goGet(getUrl).then((res) => {
                // console.log(res);return
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
                showAlert(false, "Oops! Something's not right. Try again");
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
                showAlert(false, "Oops! Something's not right. Try again");
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
            showAlert(false, "Oops! Something's not right. Try again");
        });
    }

    // Load Regular Order Modal
    function loadRegOrderModal(dishId) {
        let getUrl = `${server}/user/order-details`;
        getUrl += '/' + dishId;

        // Handle modal before showing content
        $("#order-container").empty();
        $("#order-modal-spinner").removeClass('d-none');
        $("#order-modal").modal('show');


        goGet(getUrl).then((res) => {
            if (res.success) {
                $("#order-modal-spinner").addClass('d-none');
                $("#order-container").html(res.data);
            } else {
                $("#order-modal-spinner").addClass('d-none');
                $("#order-container").html(`<div class="bg-light text-center col-md-12 pt-3 pb-3" style="height:inherit;">
                    <i class="las la-info" style="font-size:xx-large;"></i><br>
                    <small>${res.message}</small>
                </div>`);
            }
        }).catch((err) => {
            showAlert(false, "Oops! Something's not right. Try again");
        });
    }

    // Load Bulk Order Modal
    function loadBulkOrderModal(dishId) {
        let dishType = "bulk"
        let getUrl = `${server}/user/order-details`;
        getUrl += '/' + dishId + '/' + dishType;

        // Handle modal before showing content
        $("#order-container").empty();
        $("#order-modal-spinner").removeClass('d-none');
        $("#order-modal").modal('show');

        goGet(getUrl).then((res) => {
            if (res.success) {
                $("#order-modal-spinner").addClass('d-none');
                $("#order-container").html(res.data);
            } else {
                $("#order-modal-spinner").addClass('d-none');
                $("#order-container").html(`<div class="bg-light text-center col-md-12 pt-3 pb-3" style="height:inherit;">
                    <i class="las la-info" style="font-size:xx-large;"></i><br>
                    <small>${res.message}</small>
                </div>`);
            }
        }).catch((err) => {
            showAlert(false, "Oops! Something's not right. Try again");
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
            showAlert(false, "Oops! Something's not right. Try again");
        });
    }

    /*********************************** Basket/Order script */
    // Scrollspy for basket
    // $('.basket-container').on('scroll', function (e) {
    //     var elem = $(e.currentTarget);
    //     if (elem[0].scrollHeight - elem.scrollTop() == elem.outerHeight()) {
    //         getBasket(paginate.basketPage); //load content
    //     }
    // });

    $(".basket-container").loadMore({
        scrollBottom: 20,
        async: true,
        error: function () {
            getBasket(paginate.basketPage); //load content
        },
    });

    // Load user basket
    function getBasket(page = 1, toDelete = false) {
        let getUrl = `${server}/user/get-basket`;
        getUrl += fixPaginateUrl(page);

        if (toDelete == false) {
            // Add preloader on using scrollspy
            $("#basket-container-spinner-mob").removeAttr('style');
            $("#basket-container-spinner").removeAttr('style');
        }

        goGet(getUrl).then((res) => {
            // Add total amount to button
            bindBasketQtyPrice(res.total_price);

            if (toDelete == false) {
                // Clear list if loading on first page
                if (page == 1) {
                    $("#basket-container-spinner-mob").prevAll().remove();
                    $("#basket-container-spinner").prevAll().remove();
                }

                // Remove preloader
                $("#basket-container-spinner-mob").attr('style', 'display:none');
                $("#basket-container-spinner").attr('style', 'display:none');

                // Set new page
                paginate.basketPage = res.next_page;
            }

            if (res.paginate_count == 0) {
                if (page == 1) {
                    $("#basket-noti-dot, #mob-basket-noti-dot").addClass('d-none');
                    if (window.matchMedia("(max-width: 767px)")
                        .matches) { // The viewport is less than 768 pixels wide (mobile device)
                        $("#basket-container-spinner-mob").before(`<p class="mt-3">Your Basket is empty!</p>`);
                        $("#mob-head-count").html("");
                    } else {
                        $("#basket-container-spinner").before(`<p class="mt-3">Your Basket is empty!</p>`);
                        $("#head-count").html("");
                    }
                }
            } else {
                if (page == 1) {
                    $("#basket-noti-dot, #mob-basket-noti-dot").html(res.basket_count);
                    $("#basket-noti-dot, #mob-basket-noti-dot").removeClass('d-none');

                    // Check viewport
                    if (window.matchMedia("(max-width: 767px)")
                        .matches) { // The viewport is less than 768 pixels wide (mobile device)
                        if (toDelete == false) {
                            $("#basket-container-spinner-mob").before(res.basket_view);
                        }

                        $("#mob-head-count").html("(" + res.basket_count + " Items)");
                    } else {
                        if (toDelete == false) {
                            $("#basket-container-spinner").before(res.basket_view);
                        }

                        $("#head-count").html("(" + res.basket_count + " Items)");
                    }
                } else {
                    $("#basket-noti-dot, #mob-basket-noti-dot").html(res.basket_count);

                    // Check viewport
                    if (window.matchMedia("(max-width: 767px)")
                        .matches) { // The viewport is less than 768 pixels wide (mobile device)
                        if (toDelete == false) {
                            $("#basket-container-spinner-mob").before(res.basket_view);
                        }

                        $("#mob-head-count").html("(" + res.basket_count + " Items)");
                    } else {
                        if (toDelete == false) {
                            $("#basket-container-spinner").before(res.basket_view);
                        }

                        $("#head-count").html("(" + res.basket_count + " Items)");
                    }
                }

                // Validate basket data on page load
                if (res.validate_status == true) {
                    setTimeout(handleOrderValidateErr(res), 600);
                }
            }
        }).catch((err) => {
            showAlert(false, "Oops! Something's not right. Try again");
        });
    }


    // Function to fix url for pagination
    function fixPaginateUrl(page) {
        fixed_url =
            `?page=${page}`;
        return fixed_url;
    }

    function toggleAccordion(e, element) {
        $(element).parent().parent().next().collapse('toggle');
        $('.collapse').collapse('hide');
    }

    function hideAccordion() {
        $('.collapse-hide').collapse('hide');
    }

    function deleteCartItem(e, basketId, orderType, itemPosition = null) {
        let url = `${server}/user/delete-basket`;
        let formData = new FormData();


        if (orderType == "simple") {
            spin('basket-delete-' + basketId);

            formData.append('_token', _token);
            formData.append('basket_id', basketId);
            formData.append('order_type', orderType);
        } else {
            spin('basket-delete-' + basketId + '-' + itemPosition);

            formData.append('_token', _token);
            formData.append('basket_id', basketId);
            formData.append('order_type', orderType);
            formData.append('item_position', itemPosition);
        }

        goPost(url, formData)
            .then(res => {
                if (orderType == "simple") {
                    spin('basket-delete-' + basketId);
                } else {
                    spin('basket-delete-' + basketId + '-' + itemPosition);
                }

                if (handleFormRes(res)) {
                    showAlert(true, res.message);

                    // Update Basket UI
                    updateBasketOnDelete(e);

                    // Update basket total-price and number of items
                    getBasket(1, true);
                }
            })
            .catch(err => {
                if (orderType == "simple") {
                    spin('basket-delete-' + basketId);
                } else {
                    spin('basket-delete-' + basketId + '-' + itemPosition);
                }

                showAlert(false, "Oops! Something's not right. Try again");
            })
    }

    // Function removes deleted item from basket UI
    function updateBasketOnDelete(e) {
        let listItem = $(e).parent().parent();

        if (listItem.parent().children().length > 1) {
            listItem.remove();
        } else {
            listItem.parent().parent().parent().parent().parent().remove();
        }
    }

    function updateCartItem(basketId, orderType, quantity, itemPosition = null) {
        let url = `${server}/user/update-basket`;
        let formData = new FormData();

        if (orderType == "simple") {
            formData.append('_token', _token);
            formData.append('basket_id', basketId);
            formData.append('order_type', orderType);
            formData.append('quantity', quantity);
        } else {
            formData.append('_token', _token);
            formData.append('basket_id', basketId);
            formData.append('order_type', orderType);
            formData.append('item_position', itemPosition);
            formData.append('quantity', quantity);
        }

        goPost(url, formData)
            .then(res => {

                if (handleFormRes(res)) {
                    // Update total price on order button
                    bindBasketQtyPrice(res.total_price);;

                    showAlert(true, res.message);
                }
            })
            .catch(err => {
                showAlert(false, "Oops! Something's not right. Try again");
            })
    }

    function placeOrder() {
        spin('basket');
        $("#basket-order-btn").removeAttr('onclick');

        let url = `${server}/user/place-order`;
        let formData = new FormData();
        formData.append('_token', _token);

        goPost(url, formData)
            .then(res => {
                spin('basket');

                if (handleFormRes(res)) {
                    if (res.type == "error") {
                        handleOrderValidateErr(res);
                    } else {
                        // Load user basket details
                        getBasket(1);

                        // Close basket
                        $("#basket-btn").next().removeClass("show");

                        showAlert(true, res.message);
                    }
                }
            })
            .catch(err => {
                spin('basket');
                $("#basket-order-btn").attr('onclick', 'placeOrder()');

                showAlert(false, "Oops! Something's not right. Try again");
            })
    }

    // Scrollspy for order list
    $('.order-container').bind('scroll', function (e) {
        var elem = $(e.currentTarget);
        if (elem[0].scrollHeight - elem.scrollTop() == elem.outerHeight()) {
            getOrder(paginate.orderPage, paginate.orderType); //load content
        }
    });

    function getOrder(page, type = "", toCancel = false) {
        let getUrl = (type == "") ? `${server}/user/get-order` : `${server}/user/get-order/${type}`;
        getUrl += fixPaginateUrl(page);

        if (toCancel == false) {
            // Add preloader on using scrollspy
            $("#order-container-spinner-mob").removeAttr('style');
            $("#order-container-spinner").removeAttr('style');

            // Set orderType state
            paginate.orderType = type;
        }

        goGet(getUrl).then((res) => {
            if (toCancel == false) {
                // Clear list if loading on first page
                if (page == 1) {
                    $("#order-container-spinner-container-mob").prevAll().remove();
                    $("#order-container-spinner-container").prevAll().remove();
                }

                // Remove preloader
                $("#order-container-spinner-mob").attr('style', 'display:none');
                $("#order-container-spinner").attr('style', 'display:none');

                // Set new page
                paginate.orderPage = res.next_page;
            }


            if (window.matchMedia("(max-width: 767px)")
                .matches) { // The viewport is less than 768 pixels wide (mobile device)
                if (toCancel == false) {
                    $("#order-container-spinner-container-mob").before(res.order_view);
                }
                $("#mob-order-price").html(`₦${res.total_amount}.00`);

                if (type == "history") {
                    // Hide cancel button on displaying history
                    $("#mob-order-cancel-btn").addClass('d-none');

                    // Change display status
                    $("#mob-state-display").text('(History)');
                } else {
                    // Hide cancel button on displaying history
                    $("#mob-order-cancel-btn").removeClass('d-none');

                    // Change display status
                    $("#mob-state-display").text('(Today)');

                    // Disable "Cancel all" button when there is no pending order
                    if (res.pending_count == 0) {
                        $("#mob-order-cancel-btn").attr('disabled', '');
                    } else {
                        $("#mob-order-cancel-btn").removeAttr('disabled')
                    }
                }
            } else {
                if (toCancel == false) {
                    $("#order-container-spinner-container").before(res.order_view);
                }
                $("#order-price").html(`₦${res.total_amount}.00`);

                if (type == "history") {
                    // Hide cancel button on displaying history
                    $("#order-cancel-btn").addClass('d-none');

                    // Change display status
                    $("#state-display").text('(History)');
                } else {
                    // Hide cancel button on displaying history
                    $("#order-cancel-btn").removeClass('d-none');

                    // Change display status
                    $("#state-display").text('(Today)');

                    // Disable "Cancel all" button when there is no pending order
                    if (res.pending_count == 0) {
                        $("#order-cancel-btn").attr('disabled', '');
                    } else {
                        $("#order-cancel-btn").removeAttr('disabled')
                    }
                }
            }


        }).catch((err) => {
            spin('user-right-side');
            showAlert(false, "Oops! Something's not right. Try again");
        });
    }




    // Cancel all orders if parameter is empty
    function cancelOrder(element, orderId = "") {
        if (orderId == "") {
            spin('order-cancel');
        } else {
            spin('order-cancel-' + orderId);
        }

        let getUrl = (orderId == "") ? `${server}/user/cancel-order` : `${server}/user/cancel-order/${orderId}`;


        goGet(getUrl).then((res) => {
            if (orderId == "") {
                spin('order-cancel');
            } else {
                spin('order-cancel-' + orderId);
            }

            updateOrderOnDelete(element);
        }).catch((err) => {
            if (orderId == "") {
                spin('order-cancel');
            } else {
                spin('order-cancel-' + orderId);
            }

            showAlert(false, "Oops! Something's not right. Try again");
        });
    }

    // Function removes deleted item from basket UI
    function updateOrderOnDelete(e) {
        $(e).parent().parent().parent().parent().parent().remove();

        let numberElements = $(e).parent().parent().parent().parent().parent().parent().children('div').length;

        if (numberElements < 2) {
            getOrder(1);
        } else {
            getOrder(1, "", true);
        }
    }

    // Load order dropdown on click of order button
    $("#order-btn, #mob-order-btn").click(function () {
        // Always make history button show on toggling orders on mobile
        $("#mob-today-order-btn, #today-order-btn").addClass('d-none');
        $("#mob-order-history-btn, #order-history-btn").removeClass('d-none')
        // Always make history button show on toggling orders on mobile

        getOrder(1);
    });

    // Cancel all user order
    $("#order-cancel-btn, #mob-order-cancel-btn").on('click', function () {
        cancelOrder();
    });

    // Toggle Order History
    $("#order-history-btn, #mob-order-history-btn").on('click', function () {
        $(this).addClass('d-none');
        if (window.matchMedia("(max-width: 767px)")
            .matches) { // The viewport is less than 768 pixels wide (mobile device)
            $("#mob-today-order-btn").removeClass('d-none');
        } else {
            $("#today-order-btn").removeClass('d-none');
        }

        getOrder(1, "history");
    });

    // Toggle Today's Order
    $("#today-order-btn, #mob-today-order-btn").on('click', function () {
        $(this).addClass('d-none');
        if (window.matchMedia("(max-width: 767px)")
            .matches) { // The viewport is less than 768 pixels wide (mobile device)
            $("#mob-order-history-btn").removeClass('d-none');
        } else {
            $("#order-history-btn").removeClass('d-none');
        }

        getOrder(1);
    });

    // Validate quantity (on adding to basket)
    function handleValidateErr(res) {
        if (res.order_type == "simple") {
            let elemId = res.data.item;
            let newQty = res.data.new_qty;
            let message = `Only ${newQty} left`;
            $("#" + elemId).val(0);
            $("#" + elemId).attr('max', newQty);
            $("#" + elemId).attr('disabled', '');

            $("#" + elemId).next().find('button').trigger('click');
            $("#" + elemId).prev().find('button').trigger('click');
            $("#" + elemId).parent().parent().next().remove();
            $("#" + elemId).parent().parent().parent().append(
                `<div class="text-dark add-bask-err" style="margin-right: 7px; float: right; font-size:13px;"><i>${message}</i></div>`
            );
        } else {
            res.data.forEach(element => {
                let elemId = element.item;
                let newQty = element.new_qty;
                let message = `Only ${newQty} left`;
                $("#" + elemId).val(0);
                $("#" + elemId).attr('max', newQty);
                $("#" + elemId).attr('disabled', '');

                $("#" + elemId).next().find('button').trigger('click');
                $("#" + elemId).prev().find('button').trigger('click');
                $("#" + elemId).parent().parent().next().remove();
                $("#" + elemId).parent().parent().parent().append(
                    `<div class="text-dark add-bask-err" style="margin-right: 7px; float: right; font-size:13px;"><i>${message}</i></div>`
                );
            });
        }
    }

    // Validate quantity (on placing order)
    function handleOrderValidateErr(res) {
        let errorData = res.data;

        Object.values(errorData).forEach(elem => {
            if (elem.validate_type == "item_in_menu") {
                if (elem.order_type == "simple") {
                    let elemId = elem.item;
                    let newQty = elem.new_qty;
                    let message = `Only ${newQty} left`;
                    $("#" + elemId).val(0);
                    $("#" + elemId).attr('max', newQty);
                    $("#" + elemId).attr('disabled', '');

                    $("#" + elemId).next().find('button').trigger('click');
                    $("#" + elemId).prev().find('button').trigger('click');
                    $("#" + elemId).parent().parent().next().remove();
                    $("#" + elemId).parent().parent().parent().append(
                        `<div class="text-dark add-bask-err" style="margin-right: 7px; float: right; font-size:13px;"><i>${message}</i></div>`
                    );
                } else {
                    Object.values(elem.error_data).forEach(element => {
                        let elemId = element.item;
                        let newQty = element.new_qty;
                        let message = `Only ${newQty} left`;
                        $("#" + elemId).val(0);
                        $("#" + elemId).attr('max', newQty);
                        $("#" + elemId).attr('disabled', '');

                        $("#" + elemId).next().find('button').trigger('click');
                        $("#" + elemId).prev().find('button').trigger('click');
                        $("#" + elemId).parent().parent().next().remove();
                        $("#" + elemId).parent().parent().parent().append(
                            `<div class="text-dark add-bask-err" style="margin-right: 7px; float: right; font-size:13px;"><i>${message}</i></div>`
                        );
                    });
                }
            } else {
                let elemId = elem.item;
                $("#" + elemId).removeClass('d-none');
                setTimeout(function () {
                    $("#basket-order-btn").attr('disabled', 'disabled');
                }, 2000);
            }
        });
    }
    /*********************************** Basket script */


    /******** Generic Quantity input script ******************/
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

    function change(e, element, basketId, orderType, itemPosition = null) {
        minValue = parseInt($(element).attr('min'));
        maxValue = parseInt($(element).attr('max'));
        valueCurrent = parseInt($(element).val());


        let name = $(element).attr('name');
        if (valueCurrent >= minValue) {
            // $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            $(element).prev().find('button').removeAttr('disabled');
        } else {

            $(element).val($(element).data('oldValue'));
            $(element).attr('disabled', '');
        }


        if (valueCurrent <= maxValue) {
            // $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            $(element).next().find('button').removeAttr('disabled');
        } else {

            $(element).val($(this).data('oldValue'));
        }


        // Check if regular order modal is open and execute these lines
        if ($(element).data("orderType") == "regular") {
            // Compute total amount and bind to order button. Also disable and enable order button
            bindQtyPrice(element);

            // Disable and enable details input field
            handleDetailInput(element);
        } else if ($(element).data("orderType") == "bulk") {
            // Compute total amount and bind to order button. Also disable and enable order button
            bindBulkQtyPrice(element);

            // Disable and enable details input field
            handleBulkDetailInput(element);
        } else {
            updateCartItem(basketId, orderType, valueCurrent, itemPosition);
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
    /******** Generic Quantity input script ******************/




    /****** Basket specific quantity input script ***************/
    $("#mob-basket-btn").click(function () { // For mobile
        if (!$(".bas-container").hasClass('d-none')) {
            // Load user basket details
            getBasket(1);
        }
    });

    $('#basket-dropdown').on('show.bs.dropdown', function () { // For desktop
        // Load user basket details
        getBasket(1);
    });

    // Function to compute total amount and bind to order button. Also disable and enable order button
    function bindBasketQtyPrice(price) {
        let finalTotal = price;

        if (finalTotal < 1) {
            $(".basket-final-price").text('₦' + String(finalTotal.toFixed(2)));
            $(".basket-order-btn").attr('disabled', '');
        } else {
            $(".basket-final-price").text('₦' + String(finalTotal.toFixed(2)));
            $(".basket-order-btn").removeAttr('disabled');
        }
    }


    // Function to disable and enable details input field
    function handleBasketDetailInput(element) {
        valueCurrent = parseInt($(element).val());
        if (valueCurrent < 1) {
            $(element).parent().parent().prev().find('input').attr('disabled', '');
            $(element).attr('disabled', '');
        } else {
            $(element).parent().parent().prev().find('input').removeAttr('disabled');
            $(element).removeAttr('disabled');
        }
    }

    /*********************************** Basket specific quantity input script */




    /******************************* Regular order-specific quantity input script */

    // Function to compute total amount and bind to order button. Also disable and enable order button
    function bindQtyPrice(element) {
        let index = $(element).parent().parent().parent().index();
        let price = Number($(element).parent().parent().prev().find('span').text().replace('₦', '').trim());
        let qty = $(element).val();
        let finalTotal = (price * qty);
        prices[index] = finalTotal;
        finalTotal = prices.reduce((a, b) => a + b);

        if (finalTotal < 1) {
            $("#regular-final-price").text('₦' + String(finalTotal.toFixed(2)));
            $("#regular-order-btn").attr('disabled', '');
        } else {
            $("#regular-final-price").text('₦' + String(finalTotal.toFixed(2)));
            $("#regular-order-btn").removeAttr('disabled');
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
    /******************************* Regular order-specific quantity input script */


    /******************************* Bulk order-specific quantity input script */

    // Function to compute total amount and bind to order button. Also disable and enable order button
    function bindBulkQtyPrice(element) {
        let index = $(element).parent().parent().parent().index();
        let price = Number($(element).parent().parent().prev().find('span').text().replace('₦', '').trim());
        let qty = $(element).val();
        let finalTotal = (price * qty);
        bulkPrices[index] = finalTotal;
        finalTotal = bulkPrices.reduce((a, b) => a + b);

        if (finalTotal < 1) {
            $("#bulk-final-price").text('₦' + String(finalTotal.toFixed(2)));
            $("#bulk-order-btn").attr('disabled', '');
        } else {
            $("#bulk-final-price").text('₦' + String(finalTotal.toFixed(2)));
            $("#bulk-order-btn").removeAttr('disabled');
        }
    }

    // Function to disable and enable details input field
    function handleBulkDetailInput(element) {
        valueCurrent = parseInt($(element).val());
        if (valueCurrent < 1) {
            $(element).parent().parent().prev().find('input').attr('disabled', '');
            $(element).attr('disabled', '');
        } else {
            $(element).parent().parent().prev().find('input').removeAttr('disabled');
            $(element).removeAttr('disabled');
        }
    }
    /******************************* Bulk order-specific quantity input script */

    // Function to reset order price for bulk and regular
    function resetOrderPrice(orderType) {
        let prices = [];

        if (orderType == "regular") {
            // Initiate regular order-specific price input field state
            packCount = $("#price-type li").length;
            for (let i = 0; i < packCount; i++) {
                prices[i] = 0;
            }
        } else {
            // Initiate bulk order-specific price input field state
            bulkPackCount = $("#bulk-price-type li").length;
            for (let i = 0; i < bulkPackCount; i++) {
                prices[i] = 0;
            }
        }
        return prices;
    }

    $(document).ready(function () {
        // Show rating on page load
        handleRating("", rating, 'stars');

        /* 1. Visualizing things on Hover - See next part for action on click */
        $('#stars-main li').on('mouseover', function () {
            var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

            // Now highlight all the stars that's not after the current hovered star
            $(this).parent().children('li.star').each(function (e) {
                if (e < onStar) {
                    $(this).addClass('hover');
                } else {
                    $(this).removeClass('hover');
                }
            });

        }).on('mouseout', function () {
            $(this).parent().children('li.star').each(function (e) {
                $(this).removeClass('hover');
            });
        });


        /* 2. Action to perform on click */
        $('#stars-main li').on('click', function (e) {
            handleRating(e);
        });

    });

    function handleRating(e, dataValue = "", starId = "") {
        let targetEl = e != "" ? $(e.target).parent() : null;
        let onStar = dataValue == "" ? parseInt(targetEl.data('value'), 10) : parseInt(dataValue,
            10); // The star currently selected

        let stars = starId == "" ? targetEl.parent().children('li.star') : $("#" + starId).children('li.star');

        // Update star colour for stars outside rating modal
        for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
        }

        for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
        }

        // Check if user is actively rating
        if (e != "") {
            // Close rating modal
            $("#rating-modal").modal('toggle');

            // Update star colour for stars inside rating modal
            for (i = 0; i < $("#stars").children('li.star').length; i++) {
                $("#stars").children('li.star').eq(i).removeClass('selected');
            }

            for (i = 0; i < onStar; i++) {
                $("#stars").children('li.star').eq(i).addClass('selected');
            }

            // Update rating on server
            let ratingData = {
                rating: onStar,
                vendorId: "{{$vendor->id ?? ''}}",
                ratingComment: $(e.target).parent().attr('title'),
                starElement: stars,
            }

            updateRating(ratingData);
        }
    }

    function updateRating(ratingData) {
        let url = `${server}/user/rate`;
        let formData = new FormData();
        formData.append('_token', _token);
        formData.append('rating', ratingData.rating);
        formData.append('vendor_id', ratingData.vendorId);

        goPost(url, formData)
            .then(res => {
                if (handleFormRes(res)) {
                    // Add new values to rating view
                    let ratingHtml = `
                        <div class="ml-3 d-inline float-left mt-1 font-weight-bold">
                            <span>${res.data.total_rating}</span>/5
                            <sub class="d-block">You have rated this vendor.</sub>
                        </div>
                    `;

                    // Update colour of stars outside modal to reflect overall rating
                    handleRating("", Math.round(res.data.total_rating), 'stars');

                    // Update rating view on vendor profile
                    $("#rating-holder").html(ratingHtml);

                    // Add comment on rating modal on rating
                    $("#rating-comment").html(ratingData.ratingComment);

                    // Reset rating state
                    ratingState = "true";
                }
            })
            .catch(err => {
                showAlert(false, "Oops! Something's not right. Try again");
            })
    }

    // Popup rating modal
    $("#rating-view").on('click', function () {
        // Check if user has already rated
        if (ratingState == "false") {
            $("#rating-modal").modal('toggle');
        }
    });

</script>
