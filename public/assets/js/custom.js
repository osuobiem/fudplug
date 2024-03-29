$(document).ready(function () {
    $(".dropdown-menu").click((e) => {
        e.stopPropagation();
    });

    $("#comments-holder").scroll(() => {
        if (comments_holder.scrollHeight - comments_holder.scrollTop <= 420) {
            $("#see-n-comms-btn").addClass("d-none");
        }
    });

    // Toastr settings
    toastr.options.progressBar = true;
    toastr.options.positionClass = "toast-bottom-left";
});

// Fill Picked Image in Div
function fillImage(input, fillId) {
    let img = document.getElementById(fillId);

    if (input.files && input.files[0]) {
        if (input.files[0].size > 5120000) {
            showAlert(false, "Image size must not be more than 5MB");
        } else if (input.files[0].type.split("/")[0] != "image") {
            showAlert(false, "The file is not an image");
        } else {
            var reader = new FileReader();

            reader.onload = (e) => {
                img.setAttribute(
                    "style",
                    'background: url("' + e.target.result + '")'
                );
            };

            reader.onload = (e) => {
                img.setAttribute(
                    "style",
                    'background: url("' + e.target.result + '")'
                );
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
}

// Pick Image
function pickImage(inputId) {
    $("#" + inputId).click();
}

// Show Alert
function showAlert(status, message) {
    if (!status) {
        // $("#alert-error").html(message);
        // $("#alert-error").removeClass("d-none");

        // setTimeout(() => {
        //     $("#alert-error").addClass("d-none");
        //     $("#alert-error").html("");
        // }, 4000);
        // Display a warning toast, with no title
        toastr.error(message);
    } else {
        // $("#alert-success").html(message);
        // $("#alert-success").removeClass("d-none");

        // setTimeout(() => {
        //     $("#alert-success").addClass("d-none");
        //     $("#alert-success").html("");
        // }, 4000);
        toastr.success(message);
    }
}

// Generic Ajax GET function
function goGet(url) {
    return new Promise((resolve, reject) => {
        $.ajax({
                type: "GET",
                url,
            })
            .then((res) => {
                resolve(res);
            })
            .catch((err) => {
                reject(err);
            });
    });
}

// Generic Ajax POST function
function goPost(url, data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url,
            data,
            processData: false,
            contentType: false,
            statusCode: {
                200: (res) => {
                    res.status = 200;
                    resolve(res);
                },
                500: (err) => {
                    err.status = 500;
                    reject(err);
                },
                404: (err) => {
                    err.status = 404;
                    reject(err);
                },
                419: (err) => {
                    err.status = 419;
                    reject(err);
                },
            },
        });
    });
}

// Handle form error
function handleFormRes(res, form = false, prefix = false, modalAlert = false) {
    if (res.success === undefined) {
        return true;
    }

    if (res.status === 200) {
        if (!res.success) {
            errors = res.message;

            if (typeof errors === "object") {
                if (modalAlert) {
                    //If modal alert is to be used
                    let errArr = [];
                    for (const [key, value] of Object.entries(errors)) {
                        [...value].forEach((m) => {
                            errArr.push(m);
                        });
                    }
                    let uniqueChars = [...new Set(errArr)];
                    e = document.getElementById(modalAlert);
                    e.innerHTML = "<ul>";
                    uniqueChars.forEach((m) => {
                        e.innerHTML += `<li>${m}</li>`;
                    });
                    e.innerHTML += "</ul>";

                    // Show error modal after filling it with data
                    $("#" + modalAlert)
                        .parent()
                        .parent()
                        .parent()
                        .modal("show");
                } else {
                    for (const [key, value] of Object.entries(errors)) {
                        e = prefix ?
                            document.getElementById(prefix + "-" + key) :
                            document.getElementById(key);
                        e.innerHTML = "";
                        [...value].forEach((m) => {
                            e.innerHTML += `<p>${m}</p>`;
                        });
                    }
                }
                return false;
            } else {
                if (form) {
                    $("#" + form).html(errors);
                    $("#" + form).removeClass("d-none");
                } else {
                    showAlert(false, errors);
                }
                return false;
            }
        } else {
            return true;
        }
    } else {
        if (form) {
            $("#" + form).html("Oops! Something's not right. Try Again");
            $("#" + form).removeClass("d-none");
        } else {
            showAlert(false, "Oops! Something's not right. Try again");
        }
        return false;
    }
}

// Toggle Spinner
let btnDis = false;

function spin(id) {
    btnDis = btnDis ? false : true;
    $(`#${id}-txt`).toggle();
    $(`#${id}-spinner`).toggle();

    btnDis
        ?
        $(`#${id}-btn`).attr("disabled", true) :
        $(`#${id}-btn`).removeAttr("disabled");
}

// Turn off Form Errors
function offError(form = false) {
    $(".error-message").html("");
    form ? $("#" + form).addClass("d-none") : null;
}

// Pop Post Modal
let modalActive = false;

$(".post-modal-init").click(() => {
    modalActive ? null : popPostModal();
    modalActive = true;
});

$("#close-post").click(() => {
    !modalActive ? null : closePostModal();
    modalActive = false;
});

// Block that displays file names on input fields when selected
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

// Hide Error Modal OnClick
$("#error-modal").on("click", function () {
    $(this).modal("hide");
});

// Goto a apecified page
function gotoP(page) {
    location.href = page;
}

// Open Image Lightbox
function launchLight(a) {
    event.stopPropagation();

    document.getElementById("light-" + a).click();
    raiseZindex();
}

// Stop Comments Inner Event Propagation
$(".comments-inner").click(() => {
    event.stopPropagation();
});

// Scroll To Comments Bottom
function scrollToNewComments() {
    $("#comments-holder").animate({
        scrollTop: comments_holder.scrollHeight
    }, "slow")
    $("#see-n-comms-btn").addClass("d-none");
}

// Bottom Scroll Spy
function spyBottom(elId) {
    elem = $('#' + elId);
    if (parseInt(elem[0].scrollHeight) - parseInt(elem.scrollTop()) == parseInt(elem.outerHeight())) {
        return true
    }
    return false
}

// Increase z-index of lightbox
function raiseZindex() {
    raise = function () {
        if ($(".uk-open").length > 0) {
            if ($(".uk-open").attr("style") == "z-index: 3010") {
                clearInterval(interval);
            } else {
                $(".uk-open").attr("style", "z-index: 3010");
            }
        }
    };

    interval = setInterval(raise, 5);
}

// Toggle show password
function showPassword(el, id, show) {
    field = $('#'+id);
    el = $(el);

    if (show) {
        field.attr('type', 'text');
        el.removeClass('la la-eye');
        el.addClass('la la-low-vision');
        el.attr('onclick', `showPassword(this, '${id}', false)`);
        el.attr('title', `Hide Password`);
    }
    else {
        field.attr('type', 'password');
        el.removeClass('la la-low-vision');
        el.addClass('la la-eye');
        el.attr('onclick', `showPassword(this, '${id}', true)`);
        el.attr('title', `Show Password`);
    }
}