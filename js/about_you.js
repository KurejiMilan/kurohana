var bioInput, creatorCheckbox, individualRadio, companyRadio, companynameInput, companysiteInput, creatingInput, addressInput, contactInput,
    creatortypeError, companynameError, companysiteError, creatingError, addressError, contactError;

window.onload = function () {
    bioInput = document.getElementById("input-bio");
    creatorCheckbox = document.getElementById("content-creator-checkbox");
    individualRadio = document.getElementById("individual-creator-checkbox");
    companyRadio = document.getElementById("company-creator-checkbox");
    companynameInput = document.getElementById("input-companyname");
    companysiteInput = document.getElementById("input-companysite");
    creatingInput = document.getElementById("input-creating");
    addressInput = document.getElementById("input-address");
    contactInput = document.getElementById("input-contact");
    creatortypeError = document.getElementById("creator_type-error");
    companynameError = document.getElementById("companyname-error");
    companysiteError = document.getElementById("companysite-error");
    creatingError = document.getElementById("creating-error");
    addressError = document.getElementById("address-error");
    contactError = document.getElementById("contact-error");

    companynameInput.addEventListener('focus', toggleError.bind(this, 1, false));
    companysiteInput.addEventListener('focus', toggleError.bind(this, 2, false));
    creatingInput.addEventListener('focus', toggleError.bind(this, 3, false));
    addressInput.addEventListener('focus', toggleError.bind(this, 4, false));
    contactInput.addEventListener('focus', toggleError.bind(this, 5, false));


    document.getElementById('form__profile-img').addEventListener('click', function () {
        document.getElementById('input__file-select').click();
    })

    // document.getElementById('consumer-checkbox').addEventListener('change', function () {
    //     if (document.getElementById('consumer-checkbox').checked) {
    //         document.getElementById('creator-input').style.display = "none";
    //     }
    // })

    document.getElementById('content-creator-checkbox').addEventListener('change', function () {
        if (document.getElementById('content-creator-checkbox').checked) {
            document.getElementById('creator-input').style.display = "block";
        } else {
            document.getElementById('creator-input').style.display = "none";
        }
    })

    individualRadio.addEventListener('change', function () {
        if (individualRadio.checked) {
            document.getElementById('company-form').style.display = "none";
        }
    })

    companyRadio.addEventListener('change', function () {
        if (companyRadio.checked) {
            document.getElementById('company-form').style.display = "block";
        }
    })

    document.getElementById('input__file-select').addEventListener('input', function() {
        uploadProfilePicture(this);
    })
    //$("#input__file-select").change(function () {});
    document.getElementById("photo-upload__button-choose").addEventListener('input', function() {
        uploadCoverPicture(this);
    })
    //$("#photo-upload__button-choose").change(function () {});

    document.getElementById("submit-button").addEventListener("click", onSubmit.bind(this));
}

function onSubmit(e) {
    var companyname = companynameInput.value;
    var companysite = companysiteInput.value;
    var creating = creatingInput.value;
    var address = addressInput.value;
    var contact = contactInput.value;
    var topics = document.getElementsByClassName("topic__checkbox");
    if (creatorCheckbox.checked
        && ((!individualRadio.checked && !companyRadio.checked)
            || (companyRadio.checked && (companyname.trim() === "" || companysite.trim() === ""))
            || creating.trim() === ""
            || address.trim() === ""
            || contact.trim() === "")) {
        e.preventDefault();
        if (!individualRadio.checked && !companyRadio.checked) {
            toggleError(0, true, "Select One");
        }
        if (companyRadio.checked && (companyname.trim() === "" || companysite.trim() === "")) {
            if (companyname.trim() === "") {
                toggleError(1, true, "This field cannot be empty");
            }
            if (companysite.trim() === "") {
                toggleError(2, true, "This field cannot be empty");
            }
        }
        if (creating.trim() === "") {
            toggleError(3, true, "This field cannot be empty");
        }
        if (address.trim() === "") {
            toggleError(4, true, "This field cannot be empty");
        }
        if (contact.trim() === "") {
            toggleError(5, true, "This field cannot be empty");
        }
    }

    for (var i = 0; i < topics.length; i++) {
        if (topics[i].checked) {
            break;
        } else if (i === topics.length - 1) {
            e.preventDefault();
            alert("Choose atleast one Topic");
        }
    }
}

function toggleError(index, isError, errorMessage) {
    switch (index) {
        case 0: creatortypeError.innerHTML = isError ? errorMessage : "";
            break;
        case 1: isError ? showError(companynameInput, companynameError, errorMessage) : hideError(companynameInput, companynameError);
            break;
        case 2: isError ? showError(companysiteInput, companysiteError, errorMessage) : hideError(companysiteInput, companysiteError);
            break;
        case 3: isError ? showError(creatingInput, creatingError, errorMessage) : hideError(creatingInput, creatingError);
            break;
        case 4: isError ? showError(addressInput, addressError, errorMessage) : hideError(addressInput, addressError);
            break;
        case 5: isError ? showError(contactInput, contactError, errorMessage) : hideError(contactInput, contactError);
            break;
    }
}

function showError(input, error, errorMessage) {
    input.style.borderColor = "rgb(204, 78, 78)";
    error.innerHTML = errorMessage;
}

function hideError(input, error) {
    if (error.innerHTML !== "") {
        input.style.borderColor = "#AAAAAA";
        error.innerHTML = "";
    }
}

$('.role').on('change', function () {
    $('.role').not(this).prop('checked', false);
});

function openPhotoUploadDialog() {
    document.getElementById("dialog-container").style.display = "flex";
    document.getElementById("photo-upload__dialog").style.display = "block";
}

function hidePhotoUploadDialog() {
    document.getElementById("dialog-container").style.display = "none";
    document.getElementById("photo-upload__dialog").style.display = "none";
}

function uploadProfilePicture(input) {
    var profilePicture = document.getElementById("input__file-select").files[0];
    var name = profilePicture.name;
    var form_data = new FormData();
    var ext = name.split('.').pop().toLowerCase();
    if (jQuery.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
        alert("Invalid Image File");
    } else {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(profilePicture);
        var f = profilePicture;
        var fsize = f.size || f.fileSize;
        if (fsize > 2000000) {
            alert("Image File Size is very big");
        }
        else {
            form_data.append("file", profilePicture);
            $.ajax({
                url: "uploadprofile.php",
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    //alert("uploading");
                },
                success: function (data) {
                    // $('#raw').html(data);
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            document.getElementById("form__profile-img").src = e.target.result;
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            });
        }
    }
}

function uploadCoverPicture(input) {
    hidePhotoUploadDialog();
    var coverImage = document.getElementById("photo-upload__button-choose").files[0];
    var name = coverImage.name;
    var form_data = new FormData();
    var ext = name.split('.').pop().toLowerCase();
    if (jQuery.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
        alert("Invalid Image File");
    } else {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(coverImage);
        var f = coverImage;
        var fsize = f.size || f.fileSize;
        if (fsize > 2000000) {
            alert("Image File Size is very big");
        } else {
            form_data.append("file", coverImage);
            $.ajax({
                url: "uploadcover.php",
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    //alert("uploading");
                },
                success: function (data) {
                    // $('#coverimage').html(data);
                    if (data === "Success") {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                document.getElementById("cover-img").src = e.target.result;
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                }
            });
        }
    }

}