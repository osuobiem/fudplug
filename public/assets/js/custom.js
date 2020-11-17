// Fill Picked Image in Div
function fillImage(input, fillId) {
    let img = document.getElementById(fillId);

    if (input.files && input.files[0]) {
        if (input.files[0].size > 5120000) {
            showAlert(false, "Image size must not be more than 5MB");
        } else if (input.files[0].type.split("/")[0] != "image") {
            console.log("red");
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
        $("#alert-error").html(message);
        $("#alert-error").removeClass("d-none");

        setTimeout(() => {
            $("#alert-error").addClass("d-none");
            $("#alert-error").html("");
        }, 4000);
    } else {
        $("#alert-success").html(message);
        $("#alert-success").removeClass("d-none");

        setTimeout(() => {
            $("#alert-success").addClass("d-none");
            $("#alert-success").html("");
        }, 4000);
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
            showAlert(false, "Oops! Something's not right. Try Again");
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

function popPostModal() {
    $(".post-modal").removeClass("d-none");
    $(".post-modal").removeClass("animate__fadeOut");
    $(".post-modal").addClass("animate__fadeIn");
    $("#post-textarea").focus();
}

function closePostModal() {
    $(".post-modal").removeClass("animate__fadeIn");
    $(".post-modal").addClass("animate__fadeOut");
    setTimeout(() => {
        $(".post-modal").addClass("d-none");
    }, 1000);
}

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
}


// Spy for open comment modal
commentModalOpen = false;

// Open Comments Modal
function openComments(post_id) {
    $("body").addClass("modal-open");
    $(".comments-container").removeClass("d-none");

    $(".comments-inner").addClass("animate__fadeInUp");
    $(".comments-container").addClass("animate__fadeIn");

    $(".comments-inner").removeClass("animate__fadeOutDown");
    $(".comments-container").removeClass("animate__fadeOut");

    commentModalOpen = true;

    fetchComments(post_id);
}

// Close Comments Modal
function closeComments() {
    $("body").removeClass("modal-open");
    $(".comments-inner").removeClass("animate__fadeInUp");
    $(".comments-container").removeClass("animate__fadeIn");

    $(".comments-inner").addClass("animate__fadeOutDown");
    $(".comments-container").addClass("animate__fadeOut");

    commentModalOpen = false;

    setTimeout(() => {
        $(".comments-container").addClass("d-none");
    }, 500);
}

// Stop Comments Inner Event Propagation
$(".comments-inner").click(() => {
    event.stopPropagation();
});
