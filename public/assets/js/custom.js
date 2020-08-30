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
        })
            .then((res) => {
                resolve(res);
            })
            .catch((err) => {
                reject(err);
            });
    });
}

// Handle form error
function handleFormError(err, form = false, prefix = false) {
    if (err.status === 400) {
        errors = err.responseJSON.message;

        if (typeof errors === "object") {
            for (const [key, value] of Object.entries(errors)) {
                e = prefix
                    ? document.getElementById(prefix + "-" + key)
                    : document.getElementById(key);
                e.innerHTML = "";
                [...value].forEach((m) => {
                    e.innerHTML += `<p>${m}</p>`;
                });
            }
        } else {
            if (form) {
                $("#" + form).html(errors);
                $("#" + form).removeClass("d-none");
            } else {
                showAlert(false, errors);
            }
        }
    } else {
        if (form) {
            $("#" + form).html("Oops! Something's not right. Try Again");
            $("#" + form).removeClass("d-none");
        } else {
            showAlert(false, "Oops! Something's not right. Try Again");
        }
    }
}

// Toggle Spinner
function spin(id) {
    $(`#${id}-txt`).toggle();
    $(`#${id}-spinner`).toggle();
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
    $("#post-textarea").focus();
}

function closePostModal() {
    $(".post-modal").addClass("d-none");
}
