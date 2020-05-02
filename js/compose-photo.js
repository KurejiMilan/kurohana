var isTagOpen, photoList, currentPhoto;

window.onload = function () {
    isTagOpen = false;
    photoList = new Array();

    document.getElementById("btn-publish").addEventListener("click", uploadPost);
    document.getElementById("compose__input-photo-button").addEventListener("click", showPhotoUploadDialog.bind(null, null, false));
    document.getElementById("photo-upload__button-delete").addEventListener("click", deletePhoto);
    document.getElementById("photo-upload__button-choose").addEventListener("change", previewPhoto.bind(this));
}

function uploadPost() {
    var caption, tag, form_data, audience;
    form_data = new FormData();

    showProgressBar();

    caption = $("#compose__input-title").val();
    audience = $('.dropdown').val();
    tag = document.querySelector('input[name="tag"]:checked').value;
    if (photoList || (photoList.length <= 20) && (photoList.length != 0)) {
        for (var i = 0; i < photoList.length; i++) {
            form_data.append("files[]", photoList[i]);
        }
        form_data.append("caption", caption);
        form_data.append("tag", tag);
        form_data.append("totalimages", photoList.length);
        form_data.append("audience", audience);
        $.ajax({
            url: "photoUploadHandler.php",
            type: "POST",
            data: form_data,
            contentType: false,
            processData: false,
            success: function (response) {
                window.location.href = "profile.php";
            }
        });
    }
    else {
        hideProgressBar();
        if (photoList.length > 0) {
            alert("You cannot Upload more than 20 images!");
        } else {
            alert("You must upload atleast a picture!");
        }
    }
}

function showPhotoUploadDialog(event, showDelete) {
    if (photoList.length <= 20 || showDelete) {
        document.getElementById("dialog-container").style.display = "flex";
        document.getElementById("photo-upload__dialog").style.display = "block";
        if (showDelete) {
            document.getElementById("photo-upload__button-delete").style.display = "inline-block";
            document.getElementById("selected-image__preview").childNodes[1].src = event.childNodes[0].src;
            document.getElementById("selected-image__preview").style.display = "block";
            document.getElementById("photo-upload__image").style.display = "none";
            document.getElementById("photo-upload__button-choose").parentElement.style.display = "none";
            currentPhoto = event.childNodes[0].id;
            console.log(currentPhoto);
        } else {
            document.getElementById("photo-upload__button-delete").style.display = "none";
            document.getElementById("selected-image__preview").style.display = "none";
            document.getElementById("photo-upload__image").style.display = "block";
            document.getElementById("photo-upload__button-choose").parentElement.style.display = "block";
        }
    } else {
        alert("You can only upload upto 20 images");
    }
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

function deletePhoto() {
    var photoLength = photoList.length;
    var parentComposeInputPhoto = document.getElementById("compose__input-photo-list");
    for (var m=0; m < photoLength; m++){
        if(photoList[m].name === currentPhoto){
            photoList.splice(m, 1);
            for(var n=0; n< photoLength; n++){
                var tempPhoto = parentComposeInputPhoto.childNodes[n+1].childNodes[n].id;
                if(tempPhoto === currentPhoto){
                    parentComposeInputPhoto.removeChild(parentComposeInputPhoto.childNodes[n+1]);
                    currentPhoto = "";
                    hidePhotoUploadDialog();
                    break;
                }
            }
            break;
        }
    }
}

function previewPhoto(event) {
    hidePhotoUploadDialog();
    if (event.target.files && event.target.files[0]) {
        if (photoList.length + event.target.files.length <= 20) {
            //console.log(event.target.files);
            for (var i = 0; i < event.target.files.length; i++) {
                var type = event.target.files[i].name.split('.').pop().toLowerCase();
                if (jQuery.inArray(type, ['jpg', 'jpeg', 'png']) == -1) {
                    alert("Only jpg, jpeg and png extension are allowed.");
                } else {
                    var reader = new FileReader();
                    if( i == 0){
                        var firstName = event.target.files[i].name; 
                        reader.onload = function (e) {
                            renderPhotoItem(e.target.result, firstName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 1){
                        var secondName = event.target.files[i].name;
                        reader.onload = function (e) {
                            renderPhotoItem(e.target.result, secondName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 2){
                        var thirdName = event.target.files[i].name;
                        reader.onload = function (e) {
                            renderPhotoItem(e.target.result, thirdName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 3){
                        var fourthName = event.target.files[i].name;
                        reader.onload = function (e) {
                            onloadResult.push(e.target.result);
                            renderPhotoItem(e.target.result, fourthName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 4){
                        var fifthName = event.target.files[i].name;
                        reader.onload = function (e) {
                            onloadResult.push(e.target.result);
                            renderPhotoItem(e.target.result, fifthName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 5){
                        var sixthName = event.target.files[i].name;
                        reader.onload = function (e) {
                            onloadResult.push(e.target.result);
                            renderPhotoItem(e.target.result, sixthName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 6){
                        var seventhName = event.target.files[i].name;
                        reader.onload = function (e) {
                            onloadResult.push(e.target.result);
                            renderPhotoItem(e.target.result, seventhName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 7){
                        var eighthName = event.target.files[i].name; 
                        reader.onload = function (e) {
                            onloadResult.push(e.target.result);
                            renderPhotoItem(e.target.result, eighthName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 8){
                        var ninthName = event.target.files[i].name;
                        reader.onload = function (e) {
                            onloadResult.push(e.target.result);
                            renderPhotoItem(e.target.result, ninthName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 9){
                        var tenthName = event.target.files[i].name;
                        reader.onload = function (e) {
                            onloadResult.push(e.target.result);
                            renderPhotoItem(e.target.result, tenthName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 10){
                        var eleventhName = event.target.files[i].name;
                        reader.onload = function (e) {
                            onloadResult.push(e.target.result);
                            renderPhotoItem(e.target.result, eleventhName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 11){
                        var twelfthName = event.target.files[i].name;
                        reader.onload = function (e) {
                            onloadResult.push(e.target.result);
                            renderPhotoItem(e.target.result, twelfthName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 12){
                        var thirteenthName = event.target.files[i].name; 
                        reader.onload = function (e) {
                            onloadResult.push(e.target.result);
                            renderPhotoItem(e.target.result, thirteenthName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 13){
                        var fourteenthName = event.target.files[i].name;
                        reader.onload = function (e) {
                            onloadResult.push(e.target.result);
                            renderPhotoItem(e.target.result, fourteenthName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 14){
                        var fifteenthName = event.target.files[i].name;
                        reader.onload = function (e) {
                            onloadResult.push(e.target.result);
                            renderPhotoItem(e.target.result, fifteenthName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 15){
                        var sixteenthName = event.target.files[i].name;
                        reader.onload = function (e) {
                            onloadResult.push(e.target.result);
                            renderPhotoItem(e.target.result, sixteenthName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 16){
                        var seventeenthName = event.target.files[i].name;
                        reader.onload = function (e) {
                            onloadResult.push(e.target.result);
                            renderPhotoItem(e.target.result, seventeenthName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 17){
                        var eighteenthName = event.target.files[i].name;
                        reader.onload = function (e) {
                            onloadResult.push(e.target.result);
                            renderPhotoItem(e.target.result, eighteenthName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 18){
                        var ninteenthName = event.target.files[i].name;
                        reader.onload = function (e) {
                            onloadResult.push(e.target.result);
                            renderPhotoItem(e.target.result, ninteenthName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }if( i == 19){
                        var twentythName = event.target.files[i].name;
                        reader.onload = function (e) {
                            onloadResult.push(e.target.result);
                            renderPhotoItem(e.target.result, twentythName);
                        };
                        reader.onerror = function(){
                            console.log("error while loading and reading the file!");
                        };
                    }
                    reader.readAsDataURL(event.target.files[i]);
                    photoList.push(event.target.files[i]);
                }
            }
        } else {
            alert("You can only upload upto 20 images");
        }
    }
}

function renderPhotoItem(imgUrl, id) {
    var image = document.createElement("img");
    image.setAttribute("src", imgUrl);
    image.setAttribute("id", id);
    var photoItem = document.createElement("article");
    photoItem.appendChild(image);
    photoItem.setAttribute("class", "photo__preview");
    photoItem.setAttribute("onclick", "showPhotoUploadDialog(this, true)");
    document.getElementById("compose__input-photo-list").appendChild(photoItem);
}

function toggleTagDialog() {
    if (isTagOpen) {
        document.getElementById("tag-container").style.display = "none";
    } else {
        document.getElementById("tag-container").style.display = "block";
    }
    isTagOpen = !isTagOpen;
}