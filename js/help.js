var activeTab;

window.onload = function () {
    activeTab =  document.getElementsByClassName('nav__section--center')[0].dataset.action;
    //console.log(activeTab);
    if(activeTab == "faq"){
        //
    }else if(activeTab == "complain"){
        document.getElementById("faq-page").style.display = "none";
        document.getElementById("complain-page").style.display = "block";
        document.getElementsByClassName("selected-tab")[0].classList.remove("selected-tab");
        document.getElementsByClassName('tab-item')[4].classList.add("selected-tab");
    }
    document.getElementsByClassName('backbutton')[0].addEventListener('click',function(event) {
        event.preventDefault();
        window.location.href = document.getElementsByClassName('backbutton')[0].dataset.backpage; 
    });

    document.getElementById("radio-steal").addEventListener("change", function () {
        if (document.getElementById("radio-steal").checked) {
            document.getElementById("report-additional_details").style.display = "none";
        }
    })
    document.getElementById("radio-offensive").addEventListener("change", function () {
        if (document.getElementById("radio-offensive").checked) {
            document.getElementById("report-additional_details").style.display = "none";
        }
    })
    document.getElementById("radio-impersonation").addEventListener("change", function () {
        if (document.getElementById("radio-impersonation").checked) {
            document.getElementById("report-additional_details").style.display = "block";
        }
    })
    document.getElementById("radio-illegal").addEventListener("change", function () {
        if (document.getElementById("radio-illegal").checked) {
            document.getElementById("report-additional_details").style.display = "block";
        }
    })
    document.getElementById("radio-underage").addEventListener("change", function () {
        if (document.getElementById("radio-underage").checked) {
            document.getElementById("report-additional_details").style.display = "none";
        }
    })
    document.getElementById("radio-other").addEventListener("change", function () {
        if (document.getElementById("radio-other").checked) {
            document.getElementById("report-additional_details").style.display = "block";
        }
    })
}
var complainJson = {
    "0" : "stealing other people content or mine",
    "1" : "using offensive and vulgar language to hurt other users",
    "2" : "impersonation someone i know or me",
    "3" : "doing illegal activities",
    "4" : "user is under 13 years fo age",
    "5" : "other"
};
function openFAQPage(e) {
    switch (activeTab) {
        case "support":
            document.getElementById("support-page").style.display = "none";
            break;
        case "report":
            document.getElementById("report-page").style.display = "none";
            break;
        case "terms": document.getElementById("terms-page").style.display = "none";
            break;
        case "complain":
            document.getElementById("complain-page").style.display = "none";
            break;
    }
    document.getElementById("faq-page").style.display = "block";
    document.getElementsByClassName("selected-tab")[0].classList.remove("selected-tab");
    activeTab = "faq";
    e.classList.add("selected-tab");
}

function openSupportPage(e) {
    switch (activeTab) {
        case "faq":
            document.getElementById("faq-page").style.display = "none";
            break;
        case "report":
            document.getElementById("report-page").style.display = "none";
            break;
        case "terms": document.getElementById("terms-page").style.display = "none";
            break;
        case "complain":
            document.getElementById("complain-page").style.display = "none";
            break;
    }
    document.getElementById("support-page").style.display = "block";
    document.getElementsByClassName("selected-tab")[0].classList.remove("selected-tab");
    activeTab = "support";
    e.classList.add("selected-tab");
}

function openReportPage(e) {
    switch (activeTab) {
        case "faq":
            document.getElementById("faq-page").style.display = "none";
            break;
        case "support":
            document.getElementById("support-page").style.display = "none";
            break;
        case "terms": document.getElementById("terms-page").style.display = "none";
            break;
        case "complain":
            document.getElementById("complain-page").style.display = "none";
            break;
    }
    document.getElementById("report-page").style.display = "block";
    document.getElementsByClassName("selected-tab")[0].classList.remove("selected-tab");
    activeTab = "report";
    e.classList.add("selected-tab");
}

function openTermsPage(e) {
    switch (activeTab) {
        case "faq":
            document.getElementById("faq-page").style.display = "none";
            break;
        case "support":
            document.getElementById("support-page").style.display = "none";
            break;
        case "report":
            document.getElementById("report-page").style.display = "none";
            break;
        case "complain":
            document.getElementById("complain-page").style.display = "none";
            break;
    }
    document.getElementById("terms-page").style.display = "block";
    document.getElementsByClassName("selected-tab")[0].classList.remove("selected-tab");
    activeTab = "terms";
    e.classList.add("selected-tab");
}

function openComplainPage(e) {
    switch (activeTab) {
        case "faq":
            document.getElementById("faq-page").style.display = "none";
            break;
        case "support":
            document.getElementById("support-page").style.display = "none";
            break;
        case "report":
            document.getElementById("report-page").style.display = "none";
            break;
        case "terms": document.getElementById("terms-page").style.display = "none";
            break;
    }
    document.getElementById("complain-page").style.display = "block";
    document.getElementsByClassName("selected-tab")[0].classList.remove("selected-tab");
    activeTab = "complain";
    e.classList.add("selected-tab");
}

function sendReport(event) {
    var report = document.getElementsByName('report')[0];
    if(report.value != ""){
        $.ajax({
            url : "helpAction.php",
            method : "POST",
            dataType : "JSON",
            data : {
                report : report.value,
                action : 'report'
            },beforeSend : function(){
                event.innerText = "processing...";
            },success : function(response){
                if(!response['error']){
                    console.log(response);
                    event.innerText = "Send Report";
                    document.getElementById("report-page-container").style.display = "none";
                    document.getElementById("report__success-page").style.display = "block";
                    //console.log(jqXHR);
                }else{
                    event.innerText = "Send Report";
                }
            },error : function(jqXHR,exception){
                console.log(jqXHR);
                console.log(jqXHR.status);
                console.log(exception);
            }
        });
    }else{
        report.placeholder = "This field can not be empty";
    }
}

function sendInquiry() {
    document.getElementById("support-page-container").style.display = "none";
    document.getElementById("support__success-page").style.display = "block";
}

function sendComplain(event) {
    var complain = "";
    var additionalDetail = "";
    var pass = true;
    var complain_checkbox = document.getElementsByName("complain-type");
    for(var i=0; i<6;i++){
        if(complain_checkbox[i].checked){
            complain = complainJson[i];
        }
    }
    if(complain != ""){
        if(complain_checkbox[2].checked||complain_checkbox[3].checked||complain_checkbox[5].checked){
            var complain_details = document.getElementsByClassName('complain-details')[0];
            if(complain_details.value == ""){
                pass = false;
                complain_details.placeholder = "this field can not be empty in this case, user must provide additional details";
                alert("Must provide the additional details");
            }else{
                additionalDetail = complain_details.value;
            }
        }if(document.getElementById('input-name').value == ""){
            document.getElementById('input-name').placeholder = "this field can not be empty";
            pass = false;
        }if(pass){ 
            $.ajax({
                url : 'helpAction.php',
                data:{
                    url : document.getElementById('input-name').value,
                    complain : complain,
                    additionalDetail : additionalDetail,
                    action : "filingComplain"
                },
                dataType : 'JSON',
                method : 'POST',
                beforeSend : function(){
                    event.innerText = "processing...";
                },success : function(response){
                    if(!response['error']){
                        console.log(response);
                        event.innerText = "Send Complain"; 
                        document.getElementById("complain-page-container").style.display = "none";
                        document.getElementById("complain__success-page").style.display = "block";
                    }else{
                        event.innerText = "Send Complain"; 
                    }
                },error:function(jqXHR, exception){
                    console.log(jqXHR.responseText);
                    console.log(exception);
                }
            });
        }
    }else{
        alert("user must select one option!");
    }  
}