$("#login-btn").on("click", function () {
    $("#sign-up-modal").removeClass("active");
    $(".wrapper").removeClass("overlay");
    $("#login-modal").addClass("active");
    $(".wrapper").addClass("overlay");
    return false;
});

$("#login-inner > a").on("click", function () {
    $("#login-modal").removeClass("active");
    $(".wrapper").removeClass("overlay");
    return false;
});

$("#join-lk").on("click", function () {
    $("#login-modal").removeClass("active");
    $(".wrapper").removeClass("overlay");
    $("#sign-up-modal").addClass("active");
    $(".wrapper").addClass("overlay");
    return false;
});

$("#sign-up-inner > a").on("click", function () {
    $("#sign-up-modal").removeClass("active");
    $(".wrapper").removeClass("overlay");
    return false;
});

$("#login-lk").click(() => {
    $("#login-btn").click();
});
