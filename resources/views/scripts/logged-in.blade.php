<script>
    // Grab server url
    server = "{{ url('') }}";
    nserver = "{{ $node_server }}";

    // CSRF token
    token = "{{ csrf_token()}}";

    notiSound = new Audio(`${server}/assets/ding.mp3`);

    $(document).ready(function () {
        getNotifications();

        pushPermission();
        updateSW();
    });

    // Like/Unlike a post
    function likePost(post_id, likon) {
        // Animate Like
        $(likon).removeClass("animate__animated animate__pulse animate__faster");
        $(likon).addClass("animate__animated animate__heartBeat");

        likeCount = parseInt($(likon).attr("like-count"));

        doLike(likeCount, likon, post_id, true);

        url = `${server}/post/like/${post_id}`;

        goGet(url)
            .then((res) => {
                !res.success ? doUnlike(likeCount, likon, post_id) : null;
            })
            .catch((err) => {
                doUnlike(likeCount, likon, post_id);
            });
    }

    // Unlike a Post
    function unlikePost(post_id, likon) {
        // Animate Dislike
        $(likon).removeClass("animate__animated animate__heartBeat");
        $(likon).addClass("animate__animated animate__pulse animate__faster");

        likeCount = parseInt($(likon).attr("like-count"));

        doUnlike(likeCount, likon, post_id, true);

        url = `${server}/post/unlike/${post_id}`;

        goGet(url)
            .then((res) => {
                !res.success ? doLike(likeCount, likon, post_id) : null;
            })
            .catch((err) => {
                doLike(likeCount, likon, post_id);
            });
    }

    // Like
    function doLike(likeCount, likon, post_id, change = false) {
        $(likon).removeClass("la-heart-o");
        $(likon).addClass("la-heart");
        $(likon).attr("onclick", `unlikePost('${post_id}', this)`);

        if (change) {
            likeCount += 1;
        }

        $(likon).attr("like-count", likeCount);
        $($(likon).siblings()[0]).text(" " + likeCount);
    }

    // Unlike
    function doUnlike(likeCount, likon, post_id, change = false) {
        $(likon).removeClass("la-heart");
        $(likon).addClass("la-heart-o");
        $(likon).attr("onclick", `likePost('${post_id}', this)`);

        if (change) {
            likeCount = likeCount == 0 ? 0 : likeCount - 1;
        }

        $(likon).attr("like-count", likeCount);
        $($(likon).siblings()[0]).text(" " + likeCount);
    }

    // Spy for open comment modal
    commentModalOpen = false;
    openCommentsPost = null;

    // Open Comments Modal
    function openComments(post_id, type = 'comment') {
        $("body").addClass("modal-open");
        $(".comments-container").removeClass("d-none");

        $(".comments-inner").addClass("animate__fadeIn");
        $(".comments-container").addClass("animate__fadeIn");

        $(".comments-inner").removeClass("animate__fadeOut");
        $(".comments-container").removeClass("animate__fadeOut");

        commentModalOpen = true;
        openCommentsPost = post_id;

        fetchComments(post_id, type);
    }

    // Close Comments Modal
    function closeComments() {
        $("body").removeClass("modal-open");
        $(".comments-inner").removeClass("animate__fadeIn");
        $(".comments-container").removeClass("animate__fadeIn");

        $(".comments-inner").addClass("animate__fadeOut");
        $(".comments-container").addClass("animate__fadeOut");

        commentModalOpen = false;
        openCommentsPost = null;

        setTimeout(() => {
            $(".comments-container").addClass("d-none");
        }, 500);
    }

    // Delete Comment
    function deleteComment(id) {
        swal({
            title: "Are you sure?",
            buttons: ["Cancel", "Delete"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                doDelete(id);
            }
        });
    }

    // Process Comment Delete
    function doDelete(id) {
        url = `${server}/comment/delete/${id}`;
        goGet(url)
            .then((res) => {
                if (res.success) {
                    popComment(id);
                    showAlert(true, res.message);
                } else {
                    showAlert(false, res.message);
                }
            })
            .catch((err) => {
                showAlert(false, "Oops! Something's not right. Try Again");
            });
    }

    // Remove comment from container
    function popComment(id) {
        $("#comment__" + id).addClass("animate__animated animate__fadeOut");

        setTimeout(() => {
            $("#comment__" + id).remove();
        }, 500);
    }

    // Scroll to top
    function scrollToTop() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;

        $("#see-l-posts-btn").addClass("d-none");
    }

    // Get notifications
    function getNotifications(from = 0) {
        let url = `${server}/notification/get/${from}`;

        goGet(url).then((res) => {
            if (res.length > 0) {
                from == 0
                    ? $(".notification-cont-gen").html(res)
                    : $(".notification-cont-gen").append(res);
            }
        });
    }

    // Get more notifications
    function getMoreNotifications() {
        if (spyBottom("notification-container") || spyBottom("mob-notification-holder")) {
            from = $("#noti-from").text();
            getNotifications(from);
        }
    }

    // Mark notification as read
    function markAsRead(id, el) {
        event.stopPropagation();
        let url = `${server}/notification/mark-as-read/${id}`;

        goGet(url).then((res) => {
            $(el).parent().parent().removeClass("notification-card-u");
            $(el).parent().parent().addClass("notification-card-r");

            $(el).parent().parent().html(res);
        });
    }

    // Mark all notifications as read
    function markAllAsRead() {
        let url = `${server}/notification/mark-as-read`;

        goGet(url).then((res) => {
            [...$(".notification-card-u")].forEach((el) => {
                $(el).removeClass("notification-card-u");
                $(el).addClass("notification-card-r");

                $($(el).children()[1]).removeClass("col-10");
                $($(el).children()[1]).addClass("col-11");

                $($(el).children()[2]).remove();
            });
            $(".m-a-a-r").addClass("d-none");
        });
    }

    // Clear NViewed
    function clearNViewed() {
        let url = `${server}/notification/clear-nviewed`;

        goGet(url).then((res) => {
            setTimeout(() => {
                $("#noti-dot").text(0);
                $("#noti-dot").addClass("d-none");
                $("#mob-noti-dot").text(0);
                $("#mob-noti-dot").addClass("d-none");
            }, 1000);
        });
    }

    // Open Mobile Notification Dropup Modal
    function openMND() {
        $("body").addClass("modal-open");
        $(".mnd-container").removeClass("d-none");

        $(".mnd-inner").addClass("animate__fadeIn");
        $(".mnd-container").addClass("animate__fadeIn");

        $(".mnd-inner").removeClass("animate__fadeOut");
        $(".mnd-container").removeClass("animate__fadeOut");

        clearNViewed();

        mndModalOpen = true;
    }

    // Close Mobile Notification Dropup Modal
    function closeMND() {
        $("body").removeClass("modal-open");
        $(".mnd-inner").removeClass("animate__fadeIn");
        $(".mnd-container").removeClass("animate__fadeIn");

        $(".mnd-inner").addClass("animate__fadeOut");
        $(".mnd-container").addClass("animate__fadeOut");

        setTimeout(() => {
            $(".mnd-container").addClass("d-none");
        }, 500);
    }

    // Open Orders Dropup Modal
    function openOrders() {
        $("body").addClass("modal-open");
        $(".order-container").removeClass("d-none");

        $(".order-inner").addClass("animate__fadeIn");
        $(".order-container").addClass("animate__fadeIn");

        $(".order-inner").removeClass("animate__fadeOut");
        $(".order-container").removeClass("animate__fadeOut");
    }

    // Close Orders Dropup Modal
    function closeOrders() {
        $("body").removeClass("modal-open");
        $(".order-inner").removeClass("animate__fadeIn");
        $(".order-container").removeClass("animate__fadeIn");

        $(".order-inner").addClass("animate__fadeOut");
        $(".order-container").addClass("animate__fadeOut");

        setTimeout(() => {
            $(".order-container").addClass("d-none");
        }, 500);
    }

    // Open Basket Dropup Modal
    function openBasket() {
        $("body").addClass("modal-open");
        $(".bas-container").removeClass("d-none");

        $(".bas-inner").addClass("animate__fadeIn");
        $(".bas-container").addClass("animate__fadeIn");

        $(".bas-inner").removeClass("animate__fadeOut");
        $(".bas-container").removeClass("animate__fadeOut");
    }

    // Close Basket Dropup Modal
    function closeBasket() {
        $("body").removeClass("modal-open");
        $(".bas-inner").removeClass("animate__fadeIn");
        $(".bas-container").removeClass("animate__fadeIn");

        $(".bas-inner").addClass("animate__fadeOut");
        $(".bas-container").addClass("animate__fadeOut");

        setTimeout(() => {
            $(".bas-container").addClass("d-none");
        }, 500);
    }

    // Compress image
    function compressImg(image) {
        const options = {
            maxSizeMB: 0.2,
            maxWidthOrHeight: 1920,
            useWebWorker: true,
        };

        return imageCompression(image, options);
    }

    // Remove post from container
    function popPost(id) {
        $("#post__" + id).addClass("animate__animated animate__fadeOut");

        setTimeout(() => {
            $("#post__" + id).remove();
        }, 500);
    }

    // Request for push notifications permission
    function pushPermission() {
        if (
            Notification.permission == "default" ||
            Notification.permission == "denied"
        ) {
            Notification.requestPermission()
            .then(result => {
                result === 'granted' ? initializeSW() : null
            })
        }
    }

    // Send push notification
    // function sendPush(data) {
    //     new Notification("Fudplug", { 
    //         body: data.content,
    //         icon: data.icon,
    //         vibrate: [100, 50, 100],
    //         data: {
    //             url: data.url,
    //         }
    //     });
    // }

    // Update SW
    function updateSW() {
        if( Notification.permission == 'granted') {
            next_update = localStorage.getItem('sw_nu');
            
            if(!next_update) {
                initializeSW(true)
            }
            else {
                if(next_update <= `{{ time() }}`) {
                    initializeSW(true)
                }
            }
        }
    }

    // Initialize Service Worker
    function initializeSW(update = false) {
        navigator.serviceWorker.register("{{ url('assets/js/sw.js') }}")
        .then((reg) => {
                return reg.pushManager.getSubscription().then(async (subscription) => {
                    if (subscription) {
                        if(!update) {
                            return subscription;
                        }
                    }

                    // Get the server's public key
                    const publicKey = await (await fetch(`${nserver}/sw/get-pvk`)).text()
                    const convertedPublicKey = urlBase64ToUint8Array(publicKey)


                    return reg.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: convertedPublicKey
                    });
                });
            })
            .then(subscription => {
                fetch(`${server}/notification/register-wps`, {
                    method: 'post',
                    headers: {
                        'Content-type': 'application/json',
                        'X-CSRF-Token': token
                    },
                    body: JSON.stringify({
                        subscription: subscription
                    }),
                });

                localStorage.setItem('sw_nu', `{{ time() + 259200 }}`);
            })
    }

    function urlBase64ToUint8Array(base64String) {
        var padding = '='.repeat((4 - base64String.length % 4) % 4);
        var base64 = (base64String + padding)
            .replace(/\-/g, '+')
            .replace(/_/g, '/');

        var rawData = atob(base64);
        var outputArray = new Uint8Array(rawData.length);

        for (var i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    // Reach when notification is clicked
    function notificationAction(post_id, type, id) {
        if(type == 'comment' || type == 'like') {
            openComments(post_id, type);
            markAsRead(id, '#mar-'+id);
        }
    }

    // Share post
    async function sharePost(post_id, vendor_name) {
        title = 'Fudplug Post';
        text = 'Fudplug post by '.$vendor_name;
        url = `{{ url('?type=like&id=') }}${post_id}`;

        let shareData = {title, text, url};

        try {
            await navigator.share(shareData);
        } catch (error) {
            console.log(error)
            showAlert(false, 'Post share failed!')
        }
    } 
    
</script>