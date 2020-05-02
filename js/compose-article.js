var simplemde, coverPreview, photo;

window.onload = function () {
    photo = false;

    document.getElementById("compose__input-cover-preview").addEventListener("click", openPhotoUploadDialog);
    document.getElementById("btn-publish").addEventListener("click", uploadPost);
    $("#photo-upload__button-choose").change(function () {
        filePreview(this);
    });
    simplemde = new SimpleMDE({
        element: document.querySelector('#compose__input-body'),
        placeholder: "Start Here...",
        showIcons: ["code", "table", "strikethrough"]
    });
}

function openPhotoUploadDialog() {
    document.getElementById("dialog-container").style.display = "flex";
    document.getElementById("photo-upload__dialog").style.display = "block";
}

function hidePhotoUploadDialog() {
    document.getElementById("dialog-container").style.display = "none";
    document.getElementById("photo-upload__dialog").style.display = "none";
}

function showProgressBar() {
    document.getElementById("progress-bar--primary").style.display = "block";
}

function hideProgressBar() {
    document.getElementById("progress-bar--primary").style.display = "none";
}

function openTagDialog() {
    if (document.getElementById("tag-container").style.display === "none") {
        document.getElementById("tag-container").style.display = "block";
    } else {
        document.getElementById("tag-container").style.display = "none";
    }
}

function getBodyText() {
    return simplemde.value();
}

function getTag() {
    return document.querySelector('input[name="tag"]:checked').value;
}

function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("compose__input-cover-preview").src = e.target.result;
            hidePhotoUploadDialog();
        }
        reader.readAsDataURL(input.files[0]);
        photo = true;
    }
}

function uploadPost() {
    var titleinput = $('#compose__input-title').val();
    var subtitleinput = $('#compose__input-subtitle').val();
    var audience = $('.dropdown').val();
    var bodytextarea = getBodyText();
    var tag = getTag();
    var coverImage = document.getElementById("photo-upload__button-choose").files[0];

    if ((titleinput.trim() !== '') && (bodytextarea.trim() !== '') && (tag != null) && (photo == true)) {
        showProgressBar();
        var formData = new FormData();
        var type = coverImage.name.split('.').pop().toLowerCase();

        if (jQuery.inArray(type, ['png', 'jpg', 'jpeg']) == -1) {
            hideProgressBar();
            alert("Invalid Image File. Only png, jpg and jpeg image format are supported");
        } else {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(coverImage);

            var fileSize = coverImage.size || coverImage.fileSize;

            if (fileSize > 2000000) {
                hideProgressBar();
                alert("Image File Size is very big");
            } else {
                formData.append("file", coverImage);
                formData.append("titleinput", titleinput);
                formData.append("subtitleinput", subtitleinput);
                formData.append("bodytextarea", bodytextarea);
                formData.append("tag", tag);
                formData.append("audience", audience);
                $.ajax({
                    url: "uploadarticle.php",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        window.location.href = "profile.php";
                    }
                });
            }
        }
    } else if ((titleinput.trim() != '') && (bodytextarea.trim() != '') && (tag != '')) {
        showProgressBar();
        $.ajax({
            url: "uploadarticlenone.php",
            method: "POST",
            data: {
                titleinput: titleinput,
                subtitleinput: subtitleinput,
                bodytextarea: bodytextarea,
                tag: tag
            },
            success: function (data) {
                window.location.href = "profile.php";
            }
        });
    }
    else if (titleinput == '') {
        //nothing
    } else if (bodytextarea == '') {
        //nothing
    } else {
        //nothing
    }
}
