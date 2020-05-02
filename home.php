<?php 
include('./includefiles/header.inc.php');
 
if(!isset($_SESSION['user'])) {
    header("Location:index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="stylesheet" href="./css/home.css">
    <title>Home - Kurohana</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
</head>

<body>
    <nav class="top-nav">
        <a class="nav__main-link" href="#"><img src="./assets/kurohana-logo.svg" alt="Kurohana Logo"></a>
        <div class="button-icon enabled-tab" onclick="showMain(this)">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
        </div>
        <div class="button-icon" onclick="showSearch(this)">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </div>
        <section id="container-search" class="search">
            <div id="btn-back-search" class="button-icon" onclick="hideSearch(this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#989898" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </div>
            <section class="search__input">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input id="input-search" placeholder="Search">
            </section>
        </section>
        <div class="button-icon" onclick="showPostOptions()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
        </div>
        <div class="button-icon" onclick="showNotifications(this)">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
        </div>
        <section class="nav__sec">
            <button class="button-text--icon-left" onclick="showPostOptions()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#e65100" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Create</span>
            </button>
            <span class="nav__link-item">
                <a class="nav__link new-notifications" onclick='showNotificationsDialog()'>Notifications<span id="new-notification-count"></span></a>
            </span>
            <?php
			$sql="SELECT profileimage FROM userprofileimg WHERE username="."'$user'".";";
	        $result=mysqli_query($conn,$sql);
			if(mysqli_num_rows($result) == 1) {			
                $content=mysqli_fetch_assoc($result);
                $logged_profile_image=$content['profileimage'];			 
                echo '<img class="nav__img" src="./uploadprofile/'.$logged_profile_image.'" alt="" onclick=\'showProfileDialog()\'>';
            } else {
                echo '<img class="nav__img" src="./assets/default_avatar.jpg" alt="" onclick=\'showProfileDialog()\'>';
            }
            ?>
        </section>
        <div class="button-icon" onclick="showProfile(this)">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
        </div>
    </nav>
    <section id="search__result-container">
    </section>
    <aside id="aside__categories">
        <ul class="categories__list">
            <li>Art</li>
            <li>Animation</li>
            <li>Culture</li>
            <li>Internet</li>
            <li>Literature</li>
            <li>Philosophy</li>
            <li>News</li>
            <li>Programming</li>
            <li>Visual Design</li>
        </ul>
    </aside>
    <div id="main-container">
        <aside id="aside__suggestions">
            <span class="aside__suggestions-title">Suggestions For You</span>
            <section id="aside__suggestions-container">
                <article class="suggestion-user">
                    <img src="./assets/default_avatar.jpg" alt="" class="suggestion-user__image">
                    <aside>
                        <h5 class="suggestion-user__name">Sam Pakhrin</h5>
                        <h6 class="suggestion-user__interest">ARt</h6>
                    </aside>
                    <button class="button-text suggestion-user__follow">Follow</button>
                </article>
                <article class="suggestion-user">
                    <img src="./assets/default_avatar.jpg" alt="" class="suggestion-user__image">
                    <aside>
                        <h5 class="suggestion-user__name">Peter Parker</h5>
                        <h6 class="suggestion-user__interest">Educational</h6>
                    </aside>
                    <button class="button-text suggestion-user__follow">Follow</button>
                </article>
                <article class="suggestion-user">
                    <img src="./assets/default_avatar.jpg" alt="" class="suggestion-user__image">
                    <aside>
                        <h5 class="suggestion-user__name">Jhon McClane</h5>
                        <h6 class="suggestion-user__interest">Food</h6>
                    </aside>
                    <button class="button-text suggestion-user__follow">Follow</button>
                </article>
                <article class="suggestion-user">
                    <img src="./assets/default_avatar.jpg" alt="" class="suggestion-user__image">
                    <aside>
                        <h5 class="suggestion-user__name">Akira</h5>
                        <h6 class="suggestion-user__interest">Illustartion</h6>
                    </aside>
                    <button class="button-text suggestion-user__follow">Follow</button>
                </article>
            </section>
            <button class="button-text">See More Suggestions</button>
        </aside>
        <aside id="aside__trending">
            <span class="aside__trending-title">Trending</span>
            <section id="aside__trending-container">
            </section>
            <button class="button-text">See More Trending</button>
        </aside>
        <aside id="aside__feed">
            <div id="post-container"> 
            </div>
        </aside>
        <button class="button-text--secondary" id="btn-load-more">
            Load More
        </button>
    </div>
    <aside id="secondary-container">
        <div id="notifications-container" style="display:none;">
        </div>
        <div id="profile-container" style="display:none;">
            <?php
            $result=mysqli_query($conn,"SELECT following,followers,name FROM users WHERE username="."'$user'".";");
			$content=mysqli_fetch_assoc($result);
			$following_numbers=$content['following'];
			$followers_numbers=$content['followers'];
			$loggedInUserName=htmlspecialchars($content['name']);
			echo '
            <section class="user-stats">
                <a href="profile.php?user='.$user.'" style="text-decoration: none;">
                    <span id="user-displayname">'.$loggedInUserName.'</span>
                    <span id="user-username">@'.$user.'</span>
                </a>
            </section>
            <div class="profile__divider"></div>
            <section class="user-stats--numbers">
                <span>'.$followers_numbers.' Followers</span>
                <span>'.$following_numbers.' Following</span>
            </section>';
            ?>
            <div class="profile__divider"></div>
            <section class="user-options">
                <ul>
                    <li onclick="editProfile(this)" data-user="<?php echo $user;?>" >Customize your interest</li>
                </ul>
            </section>
            <div class="profile__divider"></div>
            <section class="user-options">
                <ul>
                    <li onclick="redirectSettings(this)">Settings</li>
                    <li onclick="redirectHelp(this)">Help</li>
                    <li onclick='showLogOutConfirmation(this)'>Sign out</li>
                </ul>
            </section>
        </div>
    </aside>
    <section id="dialog-container">
        <div id="post-create__dialog">
            <section class="dialog__header">
                <span class="dialog__title">Choose what you want to create</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#757575" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    onclick='hidePostOptions()'>
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </section>
            <section class="post-create__options">
                <a href="./compose-photo.php">
                    <img src="./assets/ic_photo.svg" alt="photo_img">
                    <p>Upload photos</p>
                </a>
                <a href="./compose-video.php">
                    <img src="./assets/ic_video.svg" alt="video_img">
                    <p>Upload a video</p>
                </a>
                <a href="./compose-article.php" id="create_article">
                    <img src="./assets/ic_article.svg" alt="article_img">
                    <p>Create an article</p>
                </a>
            </section>
        </div>
        <div id="logout-confirmation__dialog">
            <section class="dialog__header">
                <span class="dialog__title">Are you sure you want to Logout?</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#757575" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    onclick='hideLogOutConfirmation()'>
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </section>
            <section class="dialog__body">
                <button class="button-text--secondary" onclick='hideLogOutConfirmation()'>Cancel</button>
                <button class="button-filled--primary" id="logout" data-username="<?php echo $user;?>">Log Out</button>
            </section>
        </div>
    </section>
</body>

<script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
<script src="js/home.js"></script>
</html>