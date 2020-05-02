var coverPreview, photo;

window.onload = function () {
    photo = false;

    document.getElementById("compose__input-video").addEventListener("click", openVideoUploadDialog);
    document.getElementById("btn-publish").addEventListener("click", uploadPost);
}

function openVideoUploadDialog() {
    document.getElementById("dialog-container").style.display = "flex";
    document.getElementById("photo-upload__dialog").style.display = "block";
}

function hideVideoUploadDialog() {
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

function showPreview() {
    var link = document.getElementById("input__embed-link").value;
    document.getElementById("compose__input-video").style.display = "none";
    document.getElementById("compose__input-video-preview").style.display = "block";
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = link.match(regExp);

    if (match && match[2].length == 11) {
        document.getElementById("compose__input-video-preview").src = `https://www.youtube.com/embed/${match[2]}`;
        hideVideoUploadDialog();
    } else {
        return 'error';
    }
}

function getTag() {
    return document.querySelector('input[name="tag"]:checked').value;
}

function uploadPost() {
    var title = $('#compose__input-title').val();
    var link = $('#input__embed-link').val();
    var tag = getTag();

    if ((title.trim() !== "") && (link.trim() !== "")) {
        showProgressBar();
        var description = $('#compose__input-subtitle').val();
        $.ajax({
            url: 'videoUploadHandler.php',
            type: 'POST',
            data: {
                tag: tag,
                description: description,
                link: link,
                title: title
            },
            success: function () {
                window.location.href = "profile.php";
            }
        });
    }
    else {
        hideProgressBar();
        alert("Title and link can not be empty.");
    }
}
