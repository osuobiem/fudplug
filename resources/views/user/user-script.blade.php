<script>
    // Grab server url from script tag
    server = "{{url('')}}";

    // CSRF Token
    _token = "{{csrf_token()}}";

    $(document).ready(function () {
        // Load The Right Side when Document is Ready
        loadUserRight();

        // Load The Left Side when Document is Ready
        loadUserLeft();

        // Load user basket details
        getBasket();

        // Hide accordions on init
        hideAccordion();

        // Fetch user orders
        getOrder();
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

    // Load Bulk Order Modal
    function loadBulkOrderModal(dishId) {
        // spin('user-right-side');
        // Populate regular-order modalcontainer
        let dishType = "bulk"
        let getUrl = `${server}/user/order-details`;
        getUrl += '/' + dishId + '/' + dishType;

        goGet(getUrl).then((res) => {
            $("#bulk-order-container").html(res);
            $("#bulk-order-modal").modal('show');
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

    /*********************************** Basket/Order script */
    // Load user basket
    function getBasket() {
        let getUrl = `${server}/user/get-basket`;

        goGet(getUrl).then((res) => {
            if (res.basket_count == 0) {
                $("#basket-noti-dot, #mob-basket-noti-dot").addClass('d-none');
                $("#head-count").html("");
                if (window.matchMedia("(max-width: 767px)")
                    .matches) { // The viewport is less than 768 pixels wide (mobile device)
                    $(".mob-basket-container").html("<p>Your Basket is empty!</p>");
                } else {
                    $(".basket-container").html("<p>Your Basket is empty!</p>");
                }
            } else {
                $("#basket-noti-dot, #mob-basket-noti-dot").html(res.basket_count);
                $("#head-count").html("(" + res.basket_count + " Items)");
                $("#basket-noti-dot, #mob-basket-noti-dot").removeClass('d-none');
                // Check viewport
                if (window.matchMedia("(max-width: 767px)")
                    .matches) { // The viewport is less than 768 pixels wide (mobile device)
                    $(".mob-basket-container").html(res.basket_view);
                } else {
                    $(".basket-container").html(res.basket_view);
                }
                // Validate basket data on page load
                if (res.validate_status == true) {
                    setTimeout(handleOrderValidateErr(res), 600);
                }
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

                    // Update total price on order button
                    getBasketQtyPrice();

                    // Load user basket details
                    getBasket();
                }
            })
            .catch(err => {
                console.error(err);
            })
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
                    getBasketQtyPrice();

                    showAlert(true, res.message);
                }
            })
            .catch(err => {
                console.error(err);
            })
    }

    function placeOrder() {
        let url = `${server}/user/place-order`;
        let formData = new FormData();
        formData.append('_token', _token);

        goPost(url, formData)
            .then(res => {
                if (handleFormRes(res)) {
                    if (res.type == "error") {
                        handleOrderValidateErr(res);
                    } else {
                        // Load user basket details
                        getBasket();

                        // Close basket
                        $("#basket-btn").next().removeClass("show");

                        showAlert(true, res.message);
                    }
                }
            })
            .catch(err => {
                console.log(err);
            })
    }

    function getOrder(type = "") {
        let getUrl = (type == "") ? `${server}/user/get-order` : `${server}/user/get-order/${type}`;

        goGet(getUrl).then((res) => {
            $(".order-container").html(res.order_view);
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
                if (res.pending_count < 1) {
                    $("#order-cancel-btn").attr('disabled', '');
                }
            }
        }).catch((err) => {
            spin('user-right-side');
        });
    }

    // Cancel all orders if parameter is empty
    function cancelOrder(orderId = "") {
        let getUrl = (orderId == "") ? `${server}/user/cancel-order` : `${server}/user/cancel-order/${orderId}`;

        goGet(getUrl).then((res) => {
            getOrder();
        }).catch((err) => {
            console.log(err);
        });
    }

    // Load order dropdown on click of order button
    $("#order-btn").click(function () {
        getOrder();
    });

    // Cancel all user order
    $("#order-cancel-btn").on('click', function () {
        cancelOrder();
    });

    // Toggle Order History
    $("#order-history-btn").on('click', function () {
        $(this).addClass('d-none');
        $("#today-order-btn").removeClass('d-none');

        getOrder("history");
    });

    // Toggle Today's Order
    $("#today-order-btn").on('click', function () {
        $(this).addClass('d-none');
        $("#order-history-btn").removeClass('d-none');

        getOrder();
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
                }, 600);
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
        if ($('#regular-order-modal').hasClass('show')) {
            // Compute total amount and bind to order button. Also disable and enable order button
            bindQtyPrice(element);

            // Disable and enable details input field
            handleDetailInput(element);
        } else if ($('#bulk-order-modal').hasClass('show')) {
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
    $("#basket-btn, #mob-basket-btn").click(function () {
        getBasketQtyPrice();

        // Load user basket details
        getBasket();
    });

    // Function to get the prices and quantities to be computed
    function getBasketQtyPrice() {
        $("#basket-order-btn").attr('disabled', '');
        // Wait for three seconds before computing total
        setTimeout(getBasketQtyPriceInit, 500);
    }

    function getBasketQtyPriceInit() {
        let arr = [];
        // Get all prices from basket
        let price = $("input[name='basket_price[]']")
            .map(function () {
                return $(this).val();
            }).get();
        let quantity = $("input[name='order_quantity[]']")
            .map(function () {
                return $(this).val();
            }).get();
        if (price.length > 0 && quantity.length > 0) {
            bindBasketQtyPrice(price, quantity)
        }
    }

    // Function to compute total amount and bind to order button. Also disable and enable order button
    function bindBasketQtyPrice(price, quantity) {
        let productArr = [];
        price.forEach(function (p, index) {
            productArr[index] = (p * quantity[index]);
        });
        finalTotal = productArr.reduce((a, b) => a + b);

        if (finalTotal < 1) {
            $("#basket-final-price").text('₦' + String(finalTotal.toFixed(2)));
            $("#basket-order-btn").attr('disabled', '');
        } else {
            $("#basket-final-price").text('₦' + String(finalTotal.toFixed(2)));
            $("#basket-order-btn").removeAttr('disabled');
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
    // Initiate price input field state
    packCount = $("#price-type li").length;
    prices = [];
    for (let i = 0; i < packCount; i++) {
        prices[i] = 0;
    }

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
    // Initiate price input field state
    bulkPackCount = $("#bulk-price-type li").length;
    bulkPrices = [];
    for (let i = 0; i < bulkPackCount; i++) {
        bulkPrices[i] = 0;
    }

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

</script>
