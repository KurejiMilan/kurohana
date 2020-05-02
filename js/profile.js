'use strict';

var postslimit, comment_load_count;

$(document).ready(function () {
    comment_load_count = 10;
    postslimit = 5;
    fetch_notification();
    fetch_new_notification_num();
    getposts();

    $(document).on('click', '#action_button', function () {
        var follower = $(this).data('follower');
        var action = $(this).data('action');
        $.ajax({
            url: "action.php",
            method: "POST",
            data: { follower: follower, action: action },
            success: function (data) {
                fetch_notification();
            }
        })
    });

    $(document).on('click', '#follow_button', function () {
        var username = $(this).data('username');
        var action = $(this).data('action');
        $.ajax({
            url: "action.php",
            method: "POST",
            data: { username: username, action: action },
            success: function (data) {
                $('#follow-btn').html(data);
            }
        });
    });

    $(document).on('click', '#logout', function () {
        var user = $(this).data('username');
        window.location.href = "logout.php?user=" + user;
    });

    //loads more posts in profile page
    $(document).on('click', '#btn-load-more', function () {
        postslimit += 5;
        getposts();
    });

    $(document).on('click', '#btn-load-more', function () {
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

function postAddMenus(){
    var reportButtons = document.getElementsByClassName('reportButton');
    if(reportButtons.length >= 1){
    for (var i=0; i<reportButtons.length; i++){
        reportButtons[i].addEventListener('click',function(event) {
        //console.log(event.target.dataset.postid);
        window.location.href = "help.php?action=complain&backPage=profile.php?user="+event.target.dataset.user+"&postid="+event.target.dataset.postid;
        }); 
    }}
}

function getposts() {
    var user = $('#post-container').data('userposts');
    var name = $('#post-container').data('name');
    var userid = $('#post-container').data('id');
    var profileimage = $('#profile-img').data('profileimagename');
    $.ajax({
        url: 'profile_posts.php',
        method: 'POST',
        data: { username: user, name: name, userid: userid, profileimage: profileimage, limit: postslimit },
        success: function (data) {
            $('#post-container').html(data);
            getfeatured();
        }
    });
}


function getfeatured() {
    var user = $('#featured-container').data('username');
    var name = $('#featured-container').data('name');
    var userid = $('#featured-container').data('id');
    var profileimage = $('#profile-img').data('profileimagename');
    $.ajax({
        url: 'featured.php',
        method: 'POST',
        data: { username: user, name: name, userid: userid, profileimage: profileimage },
        success: function (data) {
            $('#featured-container').html(data);
            postAddMenus();
        }
    });
}

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

function redirectSettings(event){
    window.location.href = "settings.php?backPage=profile";
}
function redirectHelp(event){
    window.location.href = "help.php?action=faq&backPage=profile.php?user="+event.dataset.user+"&postid=none";
}
function editProfile(e){
    window.location.href = "edit_profile.php?user="+e.dataset.user;
    //console.log(e);
}
// UI HANDLERS

var btnBack, inputSearch;

btnBack = document.getElementById("btn-back-search");
inputSearch = document.getElementById("input-search");

function showPostOptions(e) {
    document.getElementById('dialog-container').style.display = 'flex';
    document.getElementById('post-create__dialog').style.display = 'block';
}

function hidePostOptions(e) {
    document.getElementById('dialog-container').style.display = 'none';
    document.getElementById('post-create__dialog').style.display = 'none';
}

function showSupportOptions() {
    document.getElementById('dialog-container').style.display = 'flex';
    document.getElementById('support__dialog').style.display = 'block';
}

function hideSupportOptions() {
    document.getElementById('dialog-container').style.display = 'none';
    document.getElementById('support__dialog').style.display = 'none';
    document.getElementsByClassName("support__options")[0].style.display = "block";
    document.getElementById("support__amount").style.display = "none";
    document.getElementById("support__dialog").getElementsByClassName("dialog__title")[0].innerText = "Choose support options";
}

function openAmountForm() {
    document.getElementsByClassName("support__options")[0].style.display = "none";
    document.getElementById("support__amount").style.display = "block";
    document.getElementById("support__dialog").getElementsByClassName("dialog__title")[0].innerText = "Enter Amount you want to donate";
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
    if (e.parentElement.parentElement.getElementsByClassName('post__settings-container')[0].style.display === "block") {
        e.parentElement.parentElement.getElementsByClassName('post__settings-container')[0].style.display = "none";
    } else {
        e.parentElement.parentElement.getElementsByClassName('post__settings-container')[0].style.display = "block";
    }
}

function hidePostSettings(e) {
    e.parentElement.style.display = "none";
}

var openTab = "none";

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

function showNotificationsDialog() {
    // Toggle notification
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
