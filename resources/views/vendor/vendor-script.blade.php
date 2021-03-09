<script>
    // Grab server url from script tag
    server = "{{ url('') }}";

    // CSRF token
    token = "{{ csrf_token()}}";


    $(document).ready(function () {
        // Variable to Hold Right Side Bar Active Tab
        let activeTab = '1';

        // Load The Right Side when Document is Ready
        loadRight(activeTab);

        // Load left side with vendor's orders
        getOrder(type = "");
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


    function getOrder(type = "") {
        let getUrl = (type == "") ? `${server}/vendor/get-order` : `${server}/vendor/get-order/${type}`;

        goGet(getUrl).then((res) => {
            if (window.matchMedia("(max-width: 767px)")
                .matches) { // The viewport is less than 768 pixels wide (mobile device)
                $(".mob-order-container").html(res.order_view);
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
                $(".desktop-order-container").html(res.order_view);
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
    $("#order-btn, #mob-order-btn").click(function () {
        // Always make history button show on toggling orders on mobile
        $("#mob-today-order-btn, #today-order-btn").addClass('d-none');
        $("#mob-order-history-btn, #order-history-btn").removeClass('d-none')
        // Always make history button show on toggling orders on mobile

        getOrder();
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

        getOrder("history");
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

        getOrder();
    });

</script>
