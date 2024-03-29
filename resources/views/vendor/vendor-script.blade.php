<script>
    // Grab server url
    server = "{{ url('') }}";

    // CSRF token
    token = "{{ csrf_token()}}";

    // Rating state variable
    @if(isset($rating_data))
    let rating = "{{round($rating_data['total_rating']) }}";
    @endif

    // Object to hold pagination state for basket and orders
    var vendorPaginate = {
        orderPage: 1,
        orderType: "",
        loadRightLastMenuId: 0,
        loadRightLastDishId: 0,
    }


    $(document).ready(function () {
        // Variable to Hold Right Side Bar Active Tab
        let activeTab = '1';

        // Load The Right Side when Document is Ready
        loadRight(activeTab);

        // Load left side with vendor's orders
        getOrder(vendorPaginate.orderPage);

        // Show rating on page load
        @if(isset($rating_data))
        handleRating("", rating, 'stars');
        @endif
    });


    function popPostModal() {
        $(".post-modal").removeClass("d-none");
        $(".post-modal").removeClass("animate__fadeOut");
        $(".post-modal").addClass("animate__fadeIn");
        $("#post-textarea")[0].emojioneArea.setFocus()
    }

    function closePostModal() {
        $(".post-modal").removeClass("animate__fadeIn");
        $(".post-modal").addClass("animate__fadeOut");
        setTimeout(() => {
            $(".post-modal").addClass("d-none");
        }, 1000);
    }

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
                $(".right-side-small").append(res.view);
                $(`#rightTab li:nth-child(${activeTab}) a`).tab('show');
            } else {
                // The viewport is at least 768 pixels wide (Desktop or tablet)
                $("#dish-menu").remove();
                $(".right-side-small").empty();
                $(".right-side-large").append(res.view);
                $(`#rightTab li:nth-child(${activeTab}) a`).tab('show');
            }

            // Update last ID pagination attributes
            vendorPaginate.loadRightLastMenuId = res.menu_last_id;
            vendorPaginate.loadRightLastDishId = res.dish_last_id;
        }).catch((err) => {
            spin('right-side');
            showAlert(false, "Oops! Something's not right. Please reload page.");
        });
    }

    // Load right side components on pagination (Vendor Dish & Menu)
    function loadMoreRight(rightSideType = "menu") {
        let lastId = rightSideType == "menu" ? vendorPaginate.loadRightLastMenuId : vendorPaginate.loadRightLastDishId;
        let getUrl = `${server}/vendor/dish/0/${rightSideType}/${lastId}`;

        // Determine where the paginated content is to be dumped
        let container = rightSideType == "menu" ? "#vendor-menu-container" : "#vendor-dish-container";

        goGet(getUrl).then((res) => {
            if (window.matchMedia("(max-width: 767px)").matches) {
                // The viewport is less than 768 pixels wide (mobile device)
                $(`${container}-small`).append(res.view);
            } else {
                // The viewport is at least 768 pixels wide (Desktop or tablet)
                $(`${container}-large`).append(res.view);
            }

            // Update last ID pagination attributes
            vendorPaginate.loadRightLastMenuId = res.menu_last_id;
            vendorPaginate.loadRightLastDishId = res.dish_last_id;
        }).catch((err) => {
            showAlert(false, "Oops! Something's not right. Please reload page.");
        });
    }

    // Load Menu Modal Data
    function loadMenuModal() {
        $("#menu-update-container").empty();
        $("#menu-update-modal-spinner").removeClass('d-none');
        $("#menu-update-modal").modal('show');

        let getUrl = `${server}/vendor/menu`;
        goGet(getUrl).then((res) => {
            $("#menu-update-modal-spinner").addClass('d-none');
            $("#menu-update-container").html(res);
            // $("#menu-update-modal").modal('show');
        }).catch((err) => {
            showAlert(false, "Oops! Something's not right. Try again");
        });
    }

    // Function Keeps Track of Active Tab
    function track(active = '1') {
        activeTab = active;
    }

    // Scrollspy for order (Mobile)
    $("#order-container-mob").loadMore({
        scrollBottom: 30,
        async: false,
        imgLoading: `<div class="col-12 text-center" id="order-preloader"><div class="spinner-border spinner-border-sm btn-pr" role="status">
<span class="sr-only">Loading...</span>
</div></div>`,
        error: function () {
            getOrder(vendorPaginate.orderPage, vendorPaginate.orderType); //load content
        },
    });

    // Scrollspy for order (Larger Screens)
    $(".desktop-order-container").loadMore({
        scrollBottom: 20,
        async: true,
        imgLoading: `<div class="col-12 text-center" id="order-preloader"><div class="spinner-border spinner-border-sm btn-pr" role="status">
<span class="sr-only">Loading...</span>
</div></div>`,
        error: function () {
            getOrder(vendorPaginate.orderPage, vendorPaginate.orderType); //load content
        },
    });

    function getOrder(page, type = "") {
        let getUrl = (type == "") ? `${server}/vendor/get-order` : `${server}/vendor/get-order/${type}`;
        getUrl += fixPaginateUrl(page);

        // Set orderType state
        vendorPaginate.orderType = type;

        goGet(getUrl).then((res) => {
            $("#order-preloader").remove();

            // Set new page
            vendorPaginate.orderPage = res.next_page;

            if (window.matchMedia("(max-width: 767px)")
                .matches) { // The viewport is less than 768 pixels wide (mobile device)
                (page == 1) ? $("#order-container-mob").html(res.order_view): $("#order-container-mob").append(
                    res.order_view);
                $("#mob-order-count").html(res.order_count);
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
                (page == 1) ? $(".desktop-order-container").html(res.order_view): $(".desktop-order-container")
                    .append(res.order_view);
                $("#order-count").html(res.order_count);
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
            $("#order-preloader").remove();
            spin('user-right-side');
            showAlert(false, err);
        });
    }

    // Function to fix url for pagination
    function fixPaginateUrl(page) {
        fixed_url =
            `?page=${page}`;
        return fixed_url;
    }


    // Cancel all orders if parameter is empty
    function rejectOrder(orderId = "") {
        let getUrl = (orderId == "") ? `${server}/vendor/reject-order` : `${server}/vendor/reject-order/${orderId}`;

        goGet(getUrl).then((res) => {
            getOrder(1);
            $('.verdict-btn').remove();
            $("#order-status").html(`<span
                                class="badge badge-warning ml-1">
                                Rejected
                            </span>`);
        }).catch((err) => {
            showAlert(false, "Oops! Something's not right. Try again");
        });
    }

    // Reject all user order
    $("#order-cancel-btn, #mob-order-cancel-btn").on('click', function () {
        rejectOrder();
    });

    // Accept all orders if parameter is empty
    function acceptOrder(orderId = "") {
        let getUrl = (orderId == "") ? `${server}/vendor/accept-order` : `${server}/vendor/accept-order/${orderId}`;

        goGet(getUrl).then((res) => {
            getOrder();
            $('.verdict-btn').remove();
            $("#order-status").html(`<span
                                class="badge badge-success ml-1">
                                Accepted
                            </span>`);
        }).catch((err) => {
            showAlert(false, "Oops! Something's not right. Try again");
        });
    }

    // Accept all user order
    $("#order-cancel-btn, #mob-order-cancel-btn").on('click', function () {
        rejectOrder();
    });

    // Load order dropdown on click of order button
    $("#order-btn, #mob-order-btn").click(function () {
        // Always make history button show on toggling orders on mobile
        $("#mob-today-order-btn, #today-order-btn").addClass('d-none');
        $("#mob-order-history-btn, #order-history-btn").removeClass('d-none')
        // Always make history button show on toggling orders on mobile

        getOrder(1);
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

    function getDetail(orderId, type = "") {
        $("#order-detail-container").empty();
        $("#order-detail-modal-spinner").removeClass('d-none');
        $("#order-detail-modal").modal('show');

        let getUrl = (type == "") ? `${server}/vendor/get-order-detail/${orderId}` :
            `${server}/vendor/get-order-detail/${orderId}/${type}`;

        goGet(getUrl).then((res) => {
            $("#order-detail-modal-spinner").addClass('d-none');
            $("#order-detail-container").html(res.order_detail_view);
            closeOrders();
        }).catch((err) => {
            spin('user-right-side');
            showAlert(false, "Oops! Something's not right. Try again");
        });
    }

    // $("#menu-update-container").empty();
    //     $("#menu-update-modal-spinner").removeClass('d-none');
    //     $("#menu-update-modal").modal('show');

    //     let getUrl = `${server}/vendor/menu`;
    //     goGet(getUrl).then((res) => {
    //         $("#menu-update-modal-spinner").addClass('d-none');
    //         $("#menu-update-container").html(res);
    //         // $("#menu-update-modal").modal('show');
    //     }).catch((err) => {
    //         showAlert(false, "Oops! Something's not right. Try again");
    //     });

    // Show client phone number
    function showContact(e) {
        $(e).remove();
        $("#contact-btn").removeClass('d-none');
    }

    // Delete Post
    function deletePost(post_id) {
        url = `${server}/post/delete/${post_id}`;
        goGet(url)
            .then((res) => {
                if (res.success) {
                    showAlert(true, res.message);
                } else {
                    showAlert(false, res.message);
                }
            })
            .catch((err) => {
                showAlert(false, "Oops! Something's not right. Try again");
            });
    }

    // Handle displaying of vendor rating
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
    }

    function blobToFile(theBlob, fileName) {
        //A Blob() is almost a File() - it's just missing the two properties below which we will add
        theBlob.lastModifiedDate = new Date();
        theBlob.name = fileName;
        return theBlob;
    }

</script>
