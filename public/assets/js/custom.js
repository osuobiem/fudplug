$("#login-btn").on("click", function () {
    $("#login-modal").addClass("active");
    $(".wrapper").addClass("overlay");
    return false;
});

$("#login-inner > a").on("click", function () {
    $("#login-modal").removeClass("active");
    $(".wrapper").removeClass("overlay");
    return false;
});
