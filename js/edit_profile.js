var bioInput, creatorCheckbox, individualRadio, companyRadio, companynameInput, companysiteInput, creatingInput, addressInput, contactInput,
    creatortypeError, companynameError, companysiteError, creatingError, addressError, contactError,uploadPhotoType;

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

    uploadPhotoType = "";
    document.getElementById('form__profile-img').addEventListener('click', function () {
        // document.getElementById('input__file-select').click();
        uploadPhotoType = "ProfileImageType";
        console.log(uploadPhotoType);
        openPhotoUploadDialog();
    })
    document.getElementById('about__cover-upload').addEventListener('click', function() {
        uploadPhotoType = "CoverImageType";
        console.log(uploadPhotoType);
        openPhotoUploadDialog();
    })

    document.getElementById("photo-upload__button-choose").addEventListener('input', function() {
        if(uploadPhotoType == "CoverImageType"){
            uploadCoverPicture(this);
        }
        if(uploadPhotoType == "ProfileImageType"){
            uploadProfilePicture(this);
        }
    })
    //$("#photo-upload__button-choose").change(function () {});

    //to display input field related to the creator
    document.getElementById('content-creator-checkbox').addEventListener('change', function () {
        if (document.getElementById('content-creator-checkbox').checked) {
            document.getElementById('creator-input').style.display = "block";
        } else {
            document.getElementById('creator-input').style.display = "none";
        }
    })
    //no need to edit
    individualRadio.addEventListener('change', function () {
        if (individualRadio.checked) {
            document.getElementById('company-form').style.display = "none";
        }
    })
    //no need to edit
    companyRadio.addEventListener('change', function () {
        if (companyRadio.checked) {
            document.getElementById('company-form').style.display = "block";
        }
    })

    //New updated part
    //these are just to me the input feel more dynamic
    var currentCompany, newCompany, currentIndividual, newIndividual, currentCompanyname, newCompanyname,currentCompanysite,
        newCompanysite, currentCreating, newCreating, currentAddress, newAddress, currentContact, newContact;
    currentCompany = false;
    newCompany = false;
    currentIndividual = false;
    newIndividual = false;
    
    currentCompanyname = companynameInput.value;
    currentCompanysite = companysiteInput.value;
    currentCreating = creatingInput.value;
    currentAddress = addressInput.value;
    currentContact = contactInput.value;

    newCompanyname = currentCompanyname;
    newCompanysite = currentCompanysite;
    newCreating = currentCreating;
    newAddress = currentAddress;
    newContact = currentContact;

    var creatingButton = document.getElementById('creatingButton');
    if(creatorCheckbox.dataset.status == "checked"){
        creatorCheckbox.checked = true;
        document.getElementById('creator-input').style.display = "block";
    }
    if(individualRadio.dataset.status == "checked"){
        individualRadio.checked = true;
        currentIndividual = true;
        newIndividual = currentIndividual;
    }
    if(companyRadio.dataset.status == "checked"){
        companyRadio.checked = true;
        currentCompany = true;
        newCompany = currentCompany;
        document.getElementById('company-form').style.display = "block";
    }

    function creatingChnageBool(){
        return ((newCompany!=currentCompany)||(newIndividual!=currentIndividual)||(newCompanyname!=currentCompanyname)||
            (newCompanysite!=currentCompanysite)||(newCreating!=currentCreating)||(newAddress!=currentAddress)||
            (newContact!=currentContact));
    }

    individualRadio.addEventListener('change', function() {
        newIndividual = individualRadio.checked;
        if(creatingChnageBool()){
            creatingButton.innerText = "Save Changes";
            creatingButton.dataset.validity = "valid";
        }else{
            creatingButton.innerText = "Saved";
            creatingButton.dataset.validity = "invalid";
        }
    })
    companyRadio.addEventListener('change', function () {
        newCompany = companyRadio.checked;
        if(creatingChnageBool()){
            creatingButton.innerText = "Save Changes";
            creatingButton.dataset.validity = "valid";
        }else{
            creatingButton.innerText = "Saved";
            creatingButton.dataset.validity = "invalid";
        }
    })
    companynameInput.addEventListener('input', function() {
        newCompanyname = companynameInput.value;
        if(creatingChnageBool()){
            creatingButton.innerText = "Save Changes";
            creatingButton.dataset.validity = "valid";
        }else{
            creatingButton.innerText = "Saved";
            creatingButton.dataset.validity = "invalid";
        }
    })
    companysiteInput.addEventListener('input', function() {
        newCompanysite = companysiteInput.value;
        if(creatingChnageBool()){
            creatingButton.innerText = "Save Changes";
            creatingButton.dataset.validity = "valid";
        }else{
            creatingButton.innerText = "Saved";
            creatingButton.dataset.validity = "invalid";
        }
    })
    creatingInput.addEventListener('input', function() {
        newCreating = creatingInput.value;
        if(creatingChnageBool()){
            creatingButton.innerText = "Save Changes";
            creatingButton.dataset.validity = "valid";
        }else{
            creatingButton.innerText = "Saved";
            creatingButton.dataset.validity = "invalid";
        }
    })
    addressInput.addEventListener('input', function() {
        newAddress = addressInput.value;
        if(creatingChnageBool()){
            creatingButton.innerText = "Save Changes";
            creatingButton.dataset.validity = "valid";
        }else{
            creatingButton.innerText = "Saved";
            creatingButton.dataset.validity = "invalid";
        }
    })
    contactInput.addEventListener('input', function() {
        newContact = contactInput.value;
        if(creatingChnageBool()){
            creatingButton.innerText = "Save Changes";
            creatingButton.dataset.validity = "valid";
        }else{
            creatingButton.innerText = "Saved";
            creatingButton.dataset.validity = "invalid";
        }
    })


    var currentBio = bioInput.value;
    var newBio = currentBio;
   
    bioInput.addEventListener('input', function() {
        newBio = bioInput.value;
        if(currentBio != newBio){
            document.getElementById('bio_Button').innerText = 'Save Changes';
            document.getElementById("bio_Button").dataset.validity = 'valid';
        }else{
            document.getElementById('bio_Button').innerText = 'Saved';
            document.getElementById("bio_Button").dataset.validity = 'invalid';
        }
    })

    var currentFacebook = document.getElementsByName("facebook")[0].value;
    var newFacebook = currentFacebook;
    var currentYoutube = document.getElementsByName("youtube")[0].value;
    var newYoutube = currentYoutube;
    var currentTwitter =  document.getElementsByName("twitter")[0].value;
    var newTwitter = currentTwitter;
    var currentInstagram = document.getElementsByName("instagram")[0].value;
    var newInstagram =currentInstagram;

    document.getElementsByName("facebook")[0].addEventListener('input', function() {
        newFacebook = document.getElementsByName("facebook")[0].value;
        if((currentFacebook!=newFacebook)||(currentYoutube!=newYoutube)||(currentTwitter!=newTwitter)||(currentInstagram!=newInstagram)){
            document.getElementById("social_links_button").innerText = "Save Changes";
            document.getElementById("social_links_button").dataset.validity = "valid";
        }else{
            document.getElementById("social_links_button").innerText = "Saved";
            document.getElementById("social_links_button").dataset.validity = "invalid";
        }
    })
    document.getElementsByName("youtube")[0].addEventListener('input', function() {
        newYoutube = document.getElementsByName("youtube")[0].value;
        if((currentFacebook!=newFacebook)||(currentYoutube!=newYoutube)||(currentTwitter!=newTwitter)||(currentInstagram!=newInstagram)){
            document.getElementById("social_links_button").innerText = "Save Changes";
            document.getElementById("social_links_button").dataset.validity = "valid";
        }else{
            document.getElementById("social_links_button").innerText = "Saved";
            document.getElementById("social_links_button").dataset.validity = "invalid";
        }
    })
    document.getElementsByName("twitter")[0].addEventListener('input', function() {
        newTwitter = document.getElementsByName("twitter")[0].value;
        if((currentFacebook!=newFacebook)||(currentYoutube!=newYoutube)||(currentTwitter!=newTwitter)||(currentInstagram!=newInstagram)){
            document.getElementById("social_links_button").innerText = "Save Changes";
            document.getElementById("social_links_button").dataset.validity = "valid";
        }else{
            document.getElementById("social_links_button").innerText = "Saved";
            document.getElementById("social_links_button").dataset.validity = "invalid";
        }
    })
    document.getElementsByName("instagram")[0].addEventListener('input', function() {
        newInstagram = document.getElementsByName("instagram")[0].value;
        if((currentFacebook!=newFacebook)||(currentYoutube!=newYoutube)||(currentTwitter!=newTwitter)||(currentInstagram!=newInstagram)){
            document.getElementById("social_links_button").innerText = "Save Changes";
            document.getElementById("social_links_button").dataset.validity = "valid";
        }else{
            document.getElementById("social_links_button").innerText = "Saved";
            document.getElementById("social_links_button").dataset.validity = "invalid";
        }
    })

    var currentArt,newArt,currentFilmAnimation,newFilmAnimation,currentNews,newNews,currentDesign,newDesign,currentMusic,newMusic,
    currentEntertainment,newEntertainment,currentComedy,newComedy,currentLiterature,newLiterature,currentDiy,newDiy,currentFashion,
    newFashion,currentScienceTech,newScienceTech,currentEducation,newEducation,currentShortStories,newShortStories,currentMangaAnime,
    newMangaAnime,currentComics,newComics;

    var topics = document.getElementsByClassName("topic__checkbox");
    currentArt =  topics.art.checked;
    currentFilmAnimation = topics.FilmAnimation.checked;
    currentNews = topics.news.checked;
    currentDesign = topics.design.checked;
    currentMusic = topics.music.checked;
    currentEntertainment = topics.entertainment.checked;
    currentComedy = topics.comedy.checked;
    currentLiterature = topics.literature.checked;
    currentDiy = topics.diy.checked;
    currentFashion = topics.fashion.checked;
    currentScienceTech = topics.scienceandtech.checked;
    currentEducation =  topics.education.checked;
    currentShortStories = topics.shortstories.checked;
    currentMangaAnime = topics.MangaAnime.checked;
    currentComics = topics.comics.checked;

    newArt = currentArt;
    newFilmAnimation = currentFilmAnimation;
    newNews = currentNews;
    newDesign = currentDesign;
    newMusic = currentMusic;
    newEntertainment = currentEntertainment;
    newComedy = currentComedy;
    newLiterature = currentLiterature;
    newDiy = currentDiy;
    newFashion = currentFashion;
    newScienceTech = currentScienceTech;
    newEducation = currentEducation;
    newShortStories = currentShortStories;
    newMangaAnime = currentMangaAnime;
    newComics = currentComics;

    var interestButton = document.getElementById('interestButton');        
    function topicsBool() {
        return ((newArt!=currentArt)||(newFilmAnimation!=currentFilmAnimation)||(newNews!=currentNews)||
        (newDesign!=currentDesign)||(newMusic!=currentMusic)||(newEntertainment!=currentEntertainment)||
        (newComedy!=currentComedy)||(newLiterature!=currentLiterature)||(newDiy!=currentDiy)||(newFashion!=currentFashion)||
        (newScienceTech!=currentScienceTech)||(newEducation!=currentEducation)||(newShortStories!=currentShortStories)||
        (newMangaAnime!=currentMangaAnime)||(newComics!=currentComics))
    }; 
    topics.art.addEventListener('change', function() {
        newArt = topics.art.checked;
        if(topicsBool()){
            interestButton.innerText = 'Save Changes';
            interestButton.dataset.validity = 'valid';
        }else{
            interestButton.innerText = 'Saved';
            interestButton.dataset.validity = 'invalid';
        }
    })
    topics.FilmAnimation.addEventListener('change', function() {
        newFilmAnimation = topics.FilmAnimation.checked;
        if(topicsBool()){
            interestButton.innerText = 'Save Changes';
            interestButton.dataset.validity = 'valid';
        }else{
            interestButton.innerText = 'Saved';
            interestButton.dataset.validity = 'invalid';
        }
    })
    topics.news.addEventListener('change', function() {
        newNews = topics.news.checked;
        if(topicsBool()){
            interestButton.innerText = 'Save Changes';
            interestButton.dataset.validity = 'valid';
        }else{
            interestButton.innerText = 'Saved';
            interestButton.dataset.validity = 'invalid';
        }
    })
    topics.design.addEventListener('change', function() {
        newDesign = topics.design.checked;
        if(topicsBool()){
            interestButton.innerText = 'Save Changes';
            interestButton.dataset.validity = 'valid';
        }else{
            interestButton.innerText = 'Saved';
            interestButton.dataset.validity = 'invalid';
        }
    })
    topics.music.addEventListener('change', function() {
        newMusic = topics.music.checked;
        if(topicsBool()){
            interestButton.innerText = 'Save Changes';
            interestButton.dataset.validity = 'valid';
        }else{
            interestButton.innerText = 'Saved';
            interestButton.dataset.validity = 'invalid';
        }
    })
    topics.entertainment.addEventListener('change', function() {
        newEntertainment = topics.entertainment.checked;
        if(topicsBool()){
            interestButton.innerText = 'Save Changes';
            interestButton.dataset.validity = 'valid';
        }else{
            interestButton.innerText = 'Saved';
            interestButton.dataset.validity = 'invalid';
        }
    })
    topics.comedy.addEventListener('change', function() {
        newComedy = topics.comedy.checked;
        if(topicsBool()){
            interestButton.innerText = 'Save Changes';
            interestButton.dataset.validity = 'valid';
        }else{
            interestButton.innerText = 'Saved';
            interestButton.dataset.validity = 'invalid';
        }
    })
    topics.literature.addEventListener('change', function() {
        newLiterature = topics.literature.checked;
        if(topicsBool()){
            interestButton.innerText = 'Save Changes';
            interestButton.dataset.validity = 'valid';
        }else{
            interestButton.innerText = 'Saved';
            interestButton.dataset.validity = 'invalid';
        }
    })
    topics.diy.addEventListener('change', function() {
        newDiy = topics.diy.checked;
        if(topicsBool()){
            interestButton.innerText = 'Save Changes';
            interestButton.dataset.validity = 'valid';
        }else{
            interestButton.innerText = 'Saved';
            interestButton.dataset.validity = 'invalid';
        }
    })
    topics.fashion.addEventListener('change', function() {
        newFashion = topics.fashion.checked;
        if(topicsBool()){
            interestButton.innerText = 'Save Changes';
            interestButton.dataset.validity = 'valid';
        }else{
            interestButton.innerText = 'Saved';
            interestButton.dataset.validity = 'invalid';
        }
    })
    topics.scienceandtech.addEventListener('change', function() {
        newScienceTech = topics.scienceandtech.checked;
        if(topicsBool()){
            interestButton.innerText = 'Save Changes';
            interestButton.dataset.validity = 'valid';
        }else{
            interestButton.innerText = 'Saved';
            interestButton.dataset.validity = 'invalid';
        }
    })
    topics.education.addEventListener('change', function() {
        newEducation = topics.education.checked;
        if(topicsBool()){
            interestButton.innerText = 'Save Changes';
            interestButton.dataset.validity = 'valid';
        }else{
            interestButton.innerText = 'Saved';
            interestButton.dataset.validity = 'invalid';
        }
    })
    topics.shortstories.addEventListener('change', function() {
        newShortStories = topics.shortstories.checked;
        if(topicsBool()){
            interestButton.innerText = 'Save Changes';
            interestButton.dataset.validity = 'valid';
        }else{
            interestButton.innerText = 'Saved';
            interestButton.dataset.validity = 'invalid';
        }
    })
    topics.MangaAnime.addEventListener('change', function() {
        newMangaAnime = topics.MangaAnime.checked;
        if(topicsBool()){
            interestButton.innerText = 'Save Changes';
            interestButton.dataset.validity = 'valid';
        }else{
            interestButton.innerText = 'Saved';
            interestButton.dataset.validity = 'invalid';
        }
    })
    topics.comics.addEventListener('change', function() {
        newComics = topics.comics.checked;
        if(topicsBool()){
            interestButton.innerText = 'Save Changes';
            interestButton.dataset.validity = 'valid';
        }else{
            interestButton.innerText = 'Saved';
            interestButton.dataset.validity = 'invalid';
        }
    })

    interestButton.addEventListener("click", function(e) {
        var passBool = false;
        for (var i = 0; i < topics.length; i++) {
            if (topics[i].checked) {
                passBool = true;
                break;
            } else if (i === topics.length - 1) {
                e.preventDefault();
                alert("Choose atleast one Topic");
            }
        }
        if(passBool){
            if(interestButton.dataset.validity == 'valid'){
                var interestJsonObj = {
                    "art" : newArt,
                    "FilmAnimation"  : newFilmAnimation,
                    "news" : newNews,
                    "design" : newDesign,
                    "music" : newMusic,
                    "entertainment" : newEntertainment,
                    "comedy" : newComedy,
                    "literature" : newLiterature,
                    "diy" : newDiy,
                    "fashion" : newFashion,
                    "scienceandtech" : newScienceTech,
                    "education" : newEducation,
                    "shortstories" : newShortStories,
                    "MangaAnime" : newMangaAnime,
                    "comics" : newComics
                };
                
                console.log(interestJsonObj);
                console.log(JSON.stringify(interestJsonObj));
                $.ajax({
                    url : "editProfileAction.php",
                    dataType : "text",
                    method : "POST",
                    data :{
                        interestString : JSON.stringify(interestJsonObj),
                        action : "updateInterest"
                    },
                    beforeSend:function(){
                        interestButton.innerText = 'Applying Changes...';
                    },success:function(result){
                        interestButton.innerText = 'Saved';
                        interestButton.dataset.validity = 'invalid';

                        currentArt = newArt;
                        currentFilmAnimation = newFilmAnimation;
                        currentNews = newNews;
                        currentDesign = newDesign;
                        currentMusic = newMusic;
                        currentEntertainment = newEntertainment;
                        currentComedy = newComedy;
                        currentLiterature = newLiterature;
                        currentDiy = newDiy;
                        currentFashion = newFashion;
                        currentScienceTech = newScienceTech;
                        currentEducation = newEducation;
                        currentShortStories = newShortStories;
                        currentMangaAnime = newMangaAnime;
                        currentComics = newComics;
                    },error:function(){
                        interestButton.innerText = 'Save  Changes';
                        alert("some kind of error occured!");
                    }
                });
            }
        }
    })

    document.getElementById('bio_Button').addEventListener('click', function() {
        if(newBio!=""){
            if(document.getElementById('bio_Button').dataset.validity == "valid"){
                $.ajax({
                    url : "editProfileAction.php",
                    method : "POST",
                    data : {
                        bio : newBio,
                        action : "updateBio"
                    },
                    beforeSend:function() {
                        document.getElementById('bio_Button').innerText = "Applying Changes...";
                    },success:function() {
                        document.getElementById('bio_Button').innerText = "Saved";
                        document.getElementById('bio_Button').dataset.validity = "invalid";
                        currentBio = newBio;
                    },error:function() {
                        document.getElementById('bio_Button').innerText = "Save Changes";
                        alert("some kind of error occured!");
                    }
                });
            }
        }else{
            alert("Bio field can not be empty.");
        }
    })
    
    var socialLinksButton = document.getElementById('social_links_button');
    social_links_button.addEventListener('click', function() {
        if(social_links_button.dataset.validity = "valid"){
            $.ajax({
                url : "editProfileAction.php",
                method : "POST",
                data : {
                    facebook : newFacebook,
                    youtube : newYoutube,
                    twitter : newTwitter,
                    instagram :  newInstagram,
                    action : "updateSocialLinks"
                },
                beforeSend:function(){
                    social_links_button.innerText = "Applying Changes...";
                },success:function(){
                    social_links_button.innerText = "Saved";
                    social_links_button.dataset.validity = "invalid";
                    currentFacebook = newFacebook;
                    currentYoutube = newYoutube;
                    currentTwitter = newTwitter;
                    currentInstagram = newInstagram;
                },error:function(){
                    social_links_button.innerText = "Save Changes";
                    alert("some kind of error occured!");
                }
            });
        }
    })

    creatingButton.addEventListener('click', function(e) {
        var passCreatingBool = true;

        if (creatorCheckbox.checked && ((!individualRadio.checked && !companyRadio.checked)
            || (companyRadio.checked && (newCompanyname.trim() === "" || newCompanysite.trim() === ""))
            || newCreating.trim() === ""|| newAddress.trim() === ""|| newContact.trim() === "")){
            e.preventDefault();
            if (!individualRadio.checked && !companyRadio.checked) {
                toggleError(0, true, "Select One");
                passCreatingBool = false;
            }
            if (companyRadio.checked && (newCompanyname.trim() === "" || newCompanysite.trim() === "")) {
                if (newCompanyname.trim() === "") {
                    toggleError(1, true, "This field cannot be empty");
                    passCreatingBool = false;
                }
                if (newCompanysite.trim() === "") {
                    toggleError(2, true, "This field cannot be empty");
                    passCreatingBool = false;
                }
            }
            if (newCreating.trim() === "") {
                toggleError(3, true, "This field cannot be empty");
                passCreatingBool = false;
            }
            if (newAddress.trim() === "") {
                toggleError(4, true, "This field cannot be empty");
                passCreatingBool = false;
            }
            if (newContact.trim() === "") {
                toggleError(5, true, "This field cannot be empty");
                passCreatingBool = false;
            }
        }
        var mobileNumber = String(newContact);
        console.log(mobileNumber);
        if(!mobileNumber.startsWith('98')){
            alert("invalid mobile number format");
            passCreatingBool = false;
        }
        if(mobileNumber.length != 10){
            alert("invalid mobile number format");
            passCreatingBool = false;
        }
        if(passCreatingBool && (creatingButton.dataset.validity=="valid")){
            var creatingJsonObj = {
                "individual" : newIndividual,
                "company" : newCompany,
                "companyname" : newCompanyname,
                "companyurl" : newCompanysite,
                "creating" : newCreating,
                "address" : newAddress,
                "contact" : mobileNumber
            };
            $.ajax({
                url : "editProfileAction.php",
                method : "POST",
                dataType : "text",
                data : {
                    creatingJsonString : JSON.stringify(creatingJsonObj),
                    action : "updateCreator"
                },
                beforeSend:function() {
                    creatingButton.innerText = "Applying Changes...";
                },success:function(result) {
                    creatingButton.innerText = "Saved";
                    creatingButton.dataset.validity = "invalid";
                    console.log(result);
                    currentCompany = newCompany;
                    currentIndividual =  newIndividual;
                    currentCompanyname = newCompanyname;
                    currentCompanysite =  newCompanysite;
                    currentCreating = newCreating;
                    currentAddress = newAddress;
                    currentContact = newContact;
                },error:function() {
                    creatingButton.innerText = "Save Changes";
                    alert('some kind of error occured!');
                }
            })
        }
    })
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
    var profilePicture = document.getElementById("photo-upload__button-choose").files[0];
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