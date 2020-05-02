var activeTab;

window.onload = function () {
    activeTab = "general";
    var currentName, newName, currentEmail, newEmail, currentAddress, newAddress, currentContact, newContact;
    var settingsButton = document.getElementById('generalSettings');
    currentName = document.getElementById('input-name').value;
    currentEmail = document.getElementById('input-email').value;
    newName = currentName;
    newEmail = currentEmail;
    currentAddress = "";
    currentContact = "";
    newAddress = currentAddress;
    newContact = currentContact;
    
    if(settingsButton.dataset.creator == "true"){
        currentAddress = document.getElementById('input-address').value;
        currentContact = document.getElementById('input-contact').value;
        newAddress = currentAddress;
        newContact = currentContact;
    }
    function generalSettingBool(){
        return ((newName!=currentName)||(newEmail!=currentEmail)||(newAddress!=currentAddress)||(newContact!=currentContact));
    }
    document.getElementById('input-name').addEventListener('input', function(){
        newName = document.getElementById('input-name').value;
        if(generalSettingBool()){
            settingsButton.innerText = "Save Changes";
            settingsButton.dataset.validity = "valid";
        }else{
            settingsButton.innerText = "Saved";
            settingsButton.dataset.validity ="invalid";
        }
    })
    document.getElementById('input-email').addEventListener('input', function(){
        newEmail = document.getElementById('input-email').value;
        if(generalSettingBool()){
            settingsButton.innerText = "Save Changes";
            settingsButton.dataset.validity = "valid";
        }else{
            settingsButton.innerText = "Saved";
            settingsButton.dataset.validity ="invalid";
        }
    })
    if(settingsButton.dataset.creator == "true"){
        document.getElementById('input-address').addEventListener('input', function(){
            newAddress = document.getElementById('input-address').value;
            if(generalSettingBool()){
                settingsButton.innerText = "Save Changes";
                settingsButton.dataset.validity = "valid";
            }else{
                settingsButton.innerText = "Saved";
                settingsButton.dataset.validity ="invalid";
            }
        })
        document.getElementById('input-contact').addEventListener('input', function(){
            newContact = document.getElementById('input-contact').value;
            if(generalSettingBool()){
                settingsButton.innerText = "Save Changes";
                settingsButton.dataset.validity = "valid";
            }else{
                settingsButton.innerText = "Saved";
                settingsButton.dataset.validity ="invalid";
            }
        })
    }
    settingsButton.addEventListener('click', function(event) {
        event.preventDefault();
        var mobileNumber = "";
        if((document.getElementById("input-name").value.length == 0)||(document.getElementById("input-email").value.length==0)){
            alert("Input fields can not be empty.");
        }else if(settingsButton.dataset.creator == "true"){
            if((document.getElementById("input-contact").value.length==0)||(document.getElementById("input-address").value.length==0)){
                alert("Input fields can not be empty.");
            }
            mobileNumber = String(newContact);
            if(!mobileNumber.startsWith('98')){
                settignsPassBool = false;
                alert("Invalid mobile number format.");
            }
            if(mobileNumber.length != 10){
                settignsPassBool = false;
                alert("Invalid mobile number format.");
            }
        }else if(settingsButton.dataset.validity == "valid"){
            var jsonSettings = {
                name : newName,
                email : newEmail,
                address : newAddress,
                contact : mobileNumber,
                creator : settingsButton.dataset.creator
            };
            //console.log(jsonSettings);
            //console.log(JSON.stringify(jsonSettings));
            $.ajax({
                url : "settingsAction.php",
                method : "POST",
                dataType : "text",
                data : {
                    jsonData : JSON.stringify(jsonSettings),
                    action : "generalSettings"
                },
                beforeSend:function(){
                    var innerText = "Applying Changes.";
                    settingsButton.innerText = innerText;
                    for(var i=0; i<6; i++){
                        for(var j=0; j<10; j++){
                            //do nothing
                        } 
                        settingsButton.innerText = innerText+".";
                    }
                },success:function(jsonObj){
                    //console.log(jsonObj);
                    if(jsonObj['error']){
                        alert(jsonObj['cause']);
                        settingsButton.innerText = "Save Changes";
                    }else{
                        settingsButton.innerText = "Saved";
                        settingsButton.dataset.validity = "invalid";
                        currentName =  newName;
                        currentEmail = newEmail;
                        currentAddress =  newAddress;
                        currentContact = newContact;
                    }
                },error:function(){
                    settingsButton.innerText = "Save Changes";
                    alert("some kind of error occured.");
                }
            });
        }
    })
    document.getElementById('confirmPasswordButton').addEventListener('click', function(event) {
        event.preventDefault();
        var oldPassword = document.getElementById('input-oldpassword').value;
        var newPassword = document.getElementById('input-newpassword').value;
        var confirmPassword = document.getElementById('input-confirmpassword').value;
        if(newPassword != confirmPassword){
            alert("the new and confirm password doesn't match.");
        }else if((newPassword.length<8)||(newPassword.length>20)){
            alert("the password must be of length between 8 and 20 character.");
        }
        else if(newPassword == oldPassword){
            //do nothing
        }else{
            $.ajax({
                url : "settingsAction.php",
                method : "POST",
                dataType : "JSON",
                data : {
                    oldPassword :oldPassword,
                    newPassword : newPassword,
                    confirmPassword : confirmPassword,
                    action : "resetPassword"
                },
                success:function(jsonObj){
                    if(jsonObj['error']){
                        alert(jsonObj['cause']);
                    }else{
                        passwordEmail();      
                    }
                },error:function(){
                    alert('some kind of error has occured.');
                }
            });
        }
    })
    document.getElementsByName('likes')[0].addEventListener('change', function() {
        $.ajax({
            url : "settingsAction.php",
            method : "POST",
            data : {
                likes : document.getElementsByName('likes')[0].checked,
                action : "likesSettings"
            },success:function(result){
                console.log(result);
            }
        });
    })
    document.getElementsByName('comments')[0].addEventListener('change', function() {
        $.ajax({
            url : "settingsAction.php",
            method : "POST",
            data : {
                comments : document.getElementsByName('comments')[0].checked,
                action : "commentsSettings"
            },success:function(result){
                console.log(result);
            }
        });
    })
    document.getElementById('backButton').addEventListener('click', function(event) {
        event.preventDefault();
        window.location.href = document.getElementById('backButton').dataset.backpage+".php";
    })
    function passwordEmail(){
        $.ajax({
            url : "resetemail.php",
            method : "POST",
            dataType : "JSON",
            success:function(){
                //do nothing
            }
        });
    }
}

function openGeneralSettings(e) {
    if (activeTab === "security") {
        document.getElementById("security-page").style.display = "none";
    } else if (activeTab === "notification") {
        document.getElementById("notification-page").style.display = "none";
    }
    document.getElementById("general-page").style.display = "block";
    document.getElementsByClassName("selected-tab")[0].classList.remove("selected-tab");
    activeTab = "general";
    e.classList.add("selected-tab");
}

function openSecuritySettings(e) {
    if (activeTab === "general") {
        document.getElementById("general-page").style.display = "none";
    } else if (activeTab === "notification") {
        document.getElementById("notification-page").style.display = "none";
    }
    document.getElementById("security-page").style.display = "block";
    document.getElementsByClassName("selected-tab")[0].classList.remove("selected-tab");
    activeTab = "security";
    e.classList.add("selected-tab");
}

function openNotificationSettings(e) {
    if (activeTab === "general") {
        document.getElementById("general-page").style.display = "none";
    } else if (activeTab === "security") {
        document.getElementById("security-page").style.display = "none";
    }
    document.getElementById("notification-page").style.display = "block";
    document.getElementsByClassName("selected-tab")[0].classList.remove("selected-tab");
    activeTab = "notification";
    e.classList.add("selected-tab");
}

function openPasswordForm() {
    document.getElementById("security-page__form").style.display = "block";
}