<?php
include('./includefiles/header.inc.php');
 
if(!isset($_SESSION['user'])) {
    header("Location:index.php");
}

if(isset($_GET['user'])) {
    $username = $_GET['user'];
    $username = htmlspecialchars($username);
    $qusername= mysqli_real_escape_string($conn,$username);
} else {
    header("Location:index.php?error=nouser");
    exit();
}
 
$sql = "SELECT * FROM users WHERE username="."'$qusername'".";";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) == 1) {
    $facebook_link = "";
	$youtube_link = "";
	$twitter_link = "";
	$instagram_link = "";
    $creating="";
    $profileimage = false;
    $coverimage=false;
    $content = mysqli_fetch_assoc($result);
	$bio = htmlspecialchars($content['bio']);
	$followers = $content['followers'];
	$following = $content['following'];
	$name = htmlspecialchars($content['name']);
    $id = $content['userid'];
	$sql = "SELECT profileimage FROM userprofileimg WHERE username="."'$qusername'".";";
    $result = mysqli_query($conn,$sql);
    
	if(mysqli_num_rows($result) == 1) {
		$content = mysqli_fetch_assoc($result);
		$profile_image_name = $content['profileimage'];
		$profileimage = true;
    }

    $result=mysqli_query($conn,"SELECT coverimage FROM coverimage WHERE username="."'$qusername'".";");
    if(mysqli_num_rows($result)==1)
    {
        $content = mysqli_fetch_assoc($result);
        $cover_image_name = $content['coverimage'];
        $coverimage = true;
    }
    
    $sql = "SELECT * FROM sociallinks WHERE username="."'$qusername'".";";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) == 1) {
        $content = mysqli_fetch_assoc($result);
        $facebook_link = $content['facebook'];
        $youtube_link = $content['youtube'];
        $twitter_link = $content['twitter'];
        $instagram_link = $content['instagram'];
    }

    $sql = "SELECT creating FROM about WHERE username="."'$qusername'".";";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) == 1) { 
        $content = mysqli_fetch_assoc($result);
        $creating = htmlspecialchars($content['creating']);	  
    }
    
} else {
    header("Location:index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="stylesheet" href="./css/profile.css" type="text/css">
    <title>Profile - Kurohana</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
     <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="top-nav">
        <a class="nav__main-link" href="home.php"><img src="./assets/kurohana-logo.svg" alt="Kurohana Logo"></a>
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
        <section class="nav__sec">
            <button class="button-text--icon-left" id="nav__create-post" onclick="showPostOptions()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#e65100" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Create</span>
            </button>
            <span class="nav__link-item">
                <a class="nav__link" onclick='showNotificationsDialog()'>Notifications<span id="new-notification-count"></span></a>
                   <!-- The span tag only looks good if there are 3 characters
                so if it's 1000 make it 1K XD yeah 1K hahaha -->
            </span>
			<?php
			$sql="SELECT profileimage FROM userprofileimg WHERE username="."'$user'".";";
	        $result=mysqli_query($conn,$sql);
			if(mysqli_num_rows($result) == 1){			
                $content=mysqli_fetch_assoc($result);
                $logged_profile_image=$content['profileimage'];			 
                echo '<img class="nav__img" src="./uploadprofile/'.$logged_profile_image.'" alt="" onclick=\'showProfileDialog()\'>';
            } else {
                echo '<img class="nav__img" src="./assets/default_avatar.jpg" alt="" onclick=\'showProfileDialog()\'>';
            }
            ?>  
	    </section>
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
    <header class="profile__header">
        <?php
        if ($coverimage == true) {
            echo '<img id="cover-img" src="./coverimage/'.$cover_image_name.'" alt="default cover">';
        } else echo '<img id="cover-img" src="./assets/cover-background.jpeg" alt="default cover">';
        if ($profileimage == true) {
            echo '<img id="profile-img" src="./uploadprofile/'.$profile_image_name.'" data-profileimagename='.$profile_image_name.' alt="avatar" />';
        } else echo '<img id="profile-img" src="./assets/default_avatar.jpg" data-profileimagename="default" alt="avatar" />';
        ?>
        <img class="verified-badge-icon" src="./assets/verified_badge.svg" alt="Verified Badge">
        <div class="profile__interaction">
            <?php echo '<h2 class="user__display-name">'.$name.'</h2>';?>
            <aside>
                <?php
                if($user == $username){
                    echo '<a href="./edit_profile.php?user='.$user.'" class="button-outlined--icon-left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        <span>Edit Profile</span>
                    </a>';
                }
                ?>   
                <div id="follow-btn">
                    <?php
                    if($user != $username){
                        $sql = "SELECT * FROM follow WHERE following="."'$qusername'"." AND followedby="."'$user'".";";
                        $result = mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result) == 0){			    
                            echo '<button class="button-outlined" type="button" id="follow_button" name="follow" data-action="followuser" data-username="'.$username.'">Follow</button>';
                        } else {
                            echo '<button class="button-filled--primary" type="button" id="follow_button" name="unfollow" data-action="unfollowuser" data-username="'.$username.'">Following</button>';
                        }
                    }
                    ?>
                </div>
                <?php if($user != $username){echo '<button class="button-outlined" onclick="showSupportOptions()">Support</button>';}?>
                <button class="button-outlined">View Revenue</button>
            </aside>
        </div>
    </header>
    <div id="main-container">
        <div id="left-container">
            <section id="profile__info">
                <span class="aside__title">About</span>
                <div id="info-container">
                    <?php echo'<h4 class="user__username">@'.$username.'</h4>';?>
                    <?php if($creating !=""){echo'<h4 class="user__create">'.$creating.'</h4>';}?>
                    <div class="profile__user-stats">
                        <section>
                            <?php echo'<span>'.$followers.'</span>';?>
                            <span>Followers</span>
                        </section>
                        <section>
                            <?php echo'<span>'.$following.'</span>';?>
                            <span>Following</span>
                        </section>
                    </div>
                    <div class="profile__social-links">
                        <?php if($facebook_link != "") echo '<a href="https://'.$facebook_link.'" target="_blank"><img src="./assets/ic_facebook.svg" alt="Facebook logo" ></a>';?>
                        <?php if($twitter_link != "") echo '<a href="https://'.$twitter_link.'" target="_blank"><img src="./assets/ic_twitter.svg" alt="Twitter logo" ></a>';?>
                        <?php if($youtube_link != "") echo '<a href="https://'.$youtube_link.'" target="_blank"><img src="./assets/ic_youtube.svg" alt="Youtube logo" ></a>';?>
                        <?php if($instagram_link != "") echo '<a href="https://'.$instagram_link.'" target="_blank"><img src="./assets/ic_instagram.svg" alt="Instagram logo" ></a>';?>
                    </div>
                </div>
            </section>
            <section id="supporters_of_month-container">
                <span class="aside__title">Supporters This Month</span>
                <section>
                    <article class="supporter-user">
                        <img src="./assets/default_avatar.jpg" alt="" class="supporter-user__image">
                        <aside>
                            <a href="./profile.php?user=sam1" class="supporter-user__name">Sam Pakhrin</a>
                            <h6 class="supporter-user__amount">Rs. 100</h6>
                        </aside>
                    </article>
                    <article class="supporter-user">
                        <img src="./assets/default_avatar.jpg" alt="" class="supporter-user__image">
                        <aside>
                            <a href="./profile.php?user=rei" class="supporter-user__name">Rei Uego</a>
                            <h6 class="supporter-user__amount">Rs. 170</h6>
                        </aside>
                    </article>
                </section>
                <button class="button-text">See More Supporters</button>
            </section>
            <section id="supporters_list-container">
                <span class="aside__title">Supporters</span>
                <section>
                    <article class="supporter-user">
                        <img src="./assets/default_avatar.jpg" alt="" class="supporter-user__image">
                        <aside>
                            <a href="./profile.php?user=sam1" class="supporter-user__name">Sam Pakhrin</a>
                            <h6 class="supporter-user__amount">Rs. 50</h6>
                        </aside>
                    </article>
                    <article class="supporter-user">
                        <img src="./assets/default_avatar.jpg" alt="" class="supporter-user__image">
                        <aside>
                            <a href="./profile.php?user=rko" class="supporter-user__name">Rook Man</a>
                            <h6 class="supporter-user__amount">Rs. 150.50</h6>
                        </aside>
                    </article>
                    <article class="supporter-user">
                        <img src="./assets/default_avatar.jpg" alt="" class="supporter-user__image">
                        <aside>
                            <a href="./profile.php?user=rei" class="supporter-user__name">Rei Uego</a>
                            <h6 class="supporter-user__amount">Rs. 170</h6>
                        </aside>
                    </article>
                </section>
                <button class="button-text">See More Supporters</button>
            </section>
        </div>
        <div id="center-container">
            <section>
                <?php echo'<p class="user__bio">'.$bio.'</p>';?>
            </section>
        </div>
        <div id="aside-container">
            <section id="aside__suggestions">
                <span class="aside__title">Suggested Creators</span>
                <section id="aside__suggestions-container">
                    <article class="suggestion-user">
                        <img src="./assets/default_avatar.jpg" alt="" class="suggestion-user__image">
                        <aside>
                            <a class="suggestion-user__name">Sam Pakhrin</a>
                            <h6 class="suggestion-user__interest">ARt</h6>
                        </aside>
                        <button class="button-text suggestion-user__follow">Follow</button>
                    </article>
                    <article class="suggestion-user">
                        <img src="./assets/default_avatar.jpg" alt="" class="suggestion-user__image">
                        <aside>
                            <a class="suggestion-user__name">Peter Parker</a>
                            <h6 class="suggestion-user__interest">Educational</h6>
                        </aside>
                        <button class="button-text suggestion-user__follow">Follow</button>
                    </article>
                    <article class="suggestion-user">
                        <img src="./assets/default_avatar.jpg" alt="" class="suggestion-user__image">
                        <aside>
                            <a class="suggestion-user__name">Jhon McClane</a>
                            <h6 class="suggestion-user__interest">Food</h6>
                        </aside>
                        <button class="button-text suggestion-user__follow">Follow</button>
                    </article>
                    <article class="suggestion-user">
                        <img src="./assets/default_avatar.jpg" alt="" class="suggestion-user__image">
                        <aside>
                            <a class="suggestion-user__name">Akira</a>
                            <h6 class="suggestion-user__interest">Illustartion</h6>
                        </aside>
                        <button class="button-text suggestion-user__follow">Follow</button>
                    </article>
                </section>
            </section>
            <aside id="aside__featured">
                <div id="featured-container" data-id="<?php echo $id;?>" data-username="<?php echo $username;?>" data-name="<?php echo $name;?>">
                </div>
            </aside>
        </div>
        <aside id="aside__feed">
            <div id="post-container" data-id="<?php echo $id;?>" data-userposts="<?php echo $username;?>" data-name="<?php echo $name;?>">
            </div>
        </aside>
    </div>
    <aside id="secondary-container">
        <div id="notifications-container" style="display:none;">
        </div>
        <div id="profile-container" style="display:none;">
            <?php
            $result = mysqli_query($conn,"SELECT following,followers,name FROM users WHERE username="."'$user'".";");
			$content = mysqli_fetch_assoc($result);
			$following_numbers = $content['following'];
			$followers_numbers = $content['followers'];
			$loggedInUserName = htmlspecialchars($content['name']);
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
                    <li onclick="editProfile(this)" data-user = "<?php echo $user;?>">Customize your interest</li>
                </ul>
            </section>
            <div class="profile__divider"></div>
            <section class="user-options">
                <ul>
                    <li onclick="redirectSettings(this)">Settings</li>
                    <li onclick="redirectHelp(this)" data-user="<?php echo $user; ?>">Help</li>
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
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
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
                <a href="./compose-article.php">
                    <img src="./assets/ic_article.svg" alt="article_img">
                    <p>Create an article</p>
                </a>
            </section>
        </div>
        <div id="support__dialog">
            <section class="dialog__header">
                <span class="dialog__title">Choose support options</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#757575" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    onclick='hideSupportOptions()'>
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </section>
            <section class="support__options">
               <img src="./assets/ic_khalti.png" alt="khalti icon" onclick="openAmountForm()">
               <img src="./assets/ic_e-sewa.jpg" alt="e-sewa icon" onclick="openAmountForm()">
            </section>
            <section id="support__amount">
                <section class="field-container">
                    <label class="field__label">Amount</label>
                    <div style="position:relative;">
                        <input id='input-amount' class='field__input--amount' type='number' max="10000">
                        <span class="field__input-icon--left">Rs.</span>
                    </div>
                    <p id="username-error" class="field__error"></p>
                </section>
                <span class="form__tip">Please be care of the amount you wish to donate.<br/>Any donations made cannot be refunded.</span>
            </section>
        </div>
        <div id="logout-confirmation__dialog">
            <section class="dialog__header">
                <span class="dialog__title">Are you sure you want to Logout?</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#757575" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    onclick='hideLogOutConfirmation()'>
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </section>
            <section class="dialog__body">
                <button class="button-text--secondary" onclick='hideLogOutConfirmation()'>Cancel</button>
                <button class="button-filled--primary" id="logout" data-username="<?php echo $user;?>">Log Out</button>
            </section>
        </div>
    </section>
</body>

<script src="./js/profile.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
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
});
</script>
</html>