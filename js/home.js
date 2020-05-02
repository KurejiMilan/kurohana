'use strict';

var btnBack, inputSearch;

btnBack = document.getElementById("btn-back-search");
inputSearch = document.getElementById("input-search");

// Post options means what kind of post to create
function showPostOptions(e) {
    document.getElementById('dialog-container').style.display = 'flex';
    document.getElementById('post-create__dialog').style.display = 'block';
}

function hidePostOptions(e) {
    document.getElementById('dialog-container').style.display = 'none';
    document.getElementById('post-create__dialog').style.display = 'none';
}

// Ask to confirm logout
function showLogOutConfirmation(e) {
    document.getElementById('dialog-container').style.display = 'flex';
    document.getElementById('logout-confirmation__dialog').style.display = 'block';
}

function hideLogOutConfirmation(e) {
    document.getElementById('dialog-container').style.display = 'none';
    document.getElementById('logout-confirmation__dialog').style.display = 'none';
}

// Show post dropdown menu
function showPostSettings(e) {
    e.parentElement.parentElement.getElementsByClassName('post__settings-container')[0].style.display = "block";
}

function hidePostSettings(e) {
    e.parentElement.style.display = "none";
}

var openTab = "none";

// For mobile screen only
function showMain(e) {
    if (document.getElementById("main-container").style.display === "none") {
        document.getElementsByClassName('enabled-tab')[0].classList.toggle("enabled-tab");
        if (openTab === "Profile") {
            document.getElementById("profile-container").style.display = "none";
        } else {
            document.getElementById("notifications-container").style.display = "none";
        }
        e.classList.toggle("enabled-tab");
        document.getElementById("secondary-container").style.display = "none";
        document.getElementById("main-container").style.display = "block";
        openTab = "none";
    }
}

// For mobile screen only
function showSearch(e) {
    document.getElementById("container-search").style.display = "flex";
    document.getElementById("aside__categories").style.display = "block";
    btnBack.style.display = "block";
}

function hideSearch(e) {
    document.getElementById("container-search").style.display = "none";
    document.getElementById("aside__categories").style.display = "none";
    inputSearch.value = "";
    btnBack.style.display = "none";
}

// For mobile screen only
function showNotifications(e) {
    if (document.getElementById("notifications-container").style.display === "none") {
        document.getElementsByClassName('enabled-tab')[0].classList.toggle("enabled-tab");
        if (openTab === "Profile") {
            document.getElementById("profile-container").style.display = "none";
        } else {
            document.getElementById("main-container").style.display = "none";
        }
        e.classList.toggle("enabled-tab");
        document.getElementById("secondary-container").style.display = "block";
        document.getElementById("notifications-container").style.display = "block";
        openTab = "Notifications";
    }
}

// For mobile screen only
function showProfile(e) {
    if (document.getElementById("profile-container").style.display === "none") {
        document.getElementsByClassName('enabled-tab')[0].classList.toggle("enabled-tab");
        if (openTab === "Notifications") {
            document.getElementById("notifications-container").style.display = "none";
        } else {
            document.getElementById("main-container").style.display = "none";
        }
        e.classList.toggle("enabled-tab");
        document.getElementById("secondary-container").style.display = "block";
        document.getElementById("profile-container").style.display = "block";
        openTab = "Profile";
    }
}

// For desktop shows notification box. This shows/hide
function showNotificationsDialog() {
    if (document.getElementById("notifications-container").style.display === "none") {
        if (openTab === "Profile") {
            document.getElementById("profile-container").style.display = "none";
        }
        document.getElementById("secondary-container").style.display = "block";
        document.getElementById("notifications-container").style.display = "block";
        openTab = "Notifications";
    } else {
        document.getElementById("secondary-container").style.display = "none";
        document.getElementById("notifications-container").style.display = "none";
        openTab = "none";
    }
    //this part was missing in previous file
    var action = 'update_notification_num';
    $.ajax({
        url: "action.php",
        method: "POST",
        data: { action: action },
        success: function (data) {
            fetch_new_notification_num();
        }
    });
}

// For desktop shows profile box. This shows/hide
function showProfileDialog() {
    if (document.getElementById("profile-container").style.display === "none") {
        if (openTab === "Notifications") {
            document.getElementById("notifications-container").style.display = "none";
        }
        document.getElementById("secondary-container").style.display = "block";
        document.getElementById("profile-container").style.display = "block";
        openTab = "Profile";
    } else {
        document.getElementById("secondary-container").style.display = "none";
        document.getElementById("profile-container").style.display = "none";
        openTab = "none";
    }
}

// Business Logic code

var comment_load_count = 10;

function fetch_notification() {
    var action = 'fetch_notification';
    $.ajax({
        url: "action.php",
        method: "POST",
        data: { action: action, count: comment_load_count },
        success: function (data) {
            $('#notifications-container').html(data);
        }
    });
}

function fetch_new_notification_num() {
    var action = 'fetch_new_notification_num';
    $.ajax({
        url: "action.php",
        method: "POST",
        data: { action: action },
        success: function (data) {
            $('#new-notification-count').html(data);
        }
    });
}

function fetch_homeposts() {
    $.ajax({
        url: "homepost.php",
        method: "POST",
        success: function (data) {
            $('#post-container').html(data);
            getTrending();
        }
    });
}

function attachReportButton(){
    var reportButton = document.getElementsByClassName('reportButton');
    if(reportButton.length >= 1){
        for(var i = 0; i < reportButton.length; i++){
            reportButton[i].addEventListener('click', function(event){
                window.location.href = "help.php?action=complain&backPage=home.php&postid="+event.target.dataset.postid;
                //console.log(event.target.dataset.postid);
            }); 
        }
    }else{
        //console.log('');
    }
}

function getTrending(){
    $.ajax({
        url:"getTrending.php",
        success: function(data) {
            $('#aside__trending-container').html(data);
            attachReportButton();
        }
    });
}

$(document).ready(function () {
    fetch_notification();
    fetch_new_notification_num();
    fetch_homeposts();
    //this part is also changed
    $(document).on('click', '.notification-load-more', function () {
        comment_load_count = comment_load_count + 10;
        var action = 'fetch_notification';
        $.ajax({
            url: "action.php",
            method: "POST",
            data: { action: action, count: comment_load_count },
            success: function (data) {
                $('#notifications-container').html(data);
            }
        });
    });
    setInterval(fetch_new_notification_num, 10000);
    setInterval(fetch_notification, 10000);
});


function onActionClick(postId) {
    var action = "updatelikebutton";
    var postid = $('#button' + postId).data('userpostid');
    var method = $('#button' + postId).data('action');
    $.ajax({
        url: "action.php",
        method: "POST",
        data: { postid: postid, action: action, method: method },
        success: function (data) {
            $('.class' + postId).html(data);
        }
    });
}

$(document).on('click', '#logout', function () {
    var user = $(this).data('username');
    // $.ajax({
    //     url: "logout.php",
    //     method: "POST",
    //     data: { logout: true },
    //     success: function (data) {
    //         window.location.href = "index.php";
    //     }
    // });
    window.location.href = "logout.php?user=" + user;
});

function redirectSettings(){
    window.location.href = "settings.php?backPage=home";
}

function redirectHelp(){
    window.location.href = "help.php?action=faq&backPage=home.php&postid=none";
}

function editProfile(e){
    window.location.href = "edit_profile.php?user="+e.dataset.user;
}