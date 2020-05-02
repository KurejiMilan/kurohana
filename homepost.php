<?php

require('./includefiles/header.inc.php');

$output = "";
$sql = "SELECT posts.id,posts.userid,posts.username,posts.type FROM posts,follow WHERE posts.username=follow.following AND follow.followedby="."'$user'"." ORDER BY posts.id DESC;";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) > 0) {
    $content = mysqli_fetch_all($result,MYSQLI_ASSOC);

    foreach ($content as $content) {
    	if($content['type'] == 'article')  {
    		$likebutton = "";
    		$postid = $content['id'];
    		$username = $content['username'];
    		$userid = $content['userid'];
    		$res = mysqli_query($conn,"SELECT * FROM likes WHERE postid=$postid AND likedby="."'$user'".";") or die("ERROR"); 
                
            if(mysqli_num_rows($res) == 1) {
                $likebutton = '<button class="button-icon--small post__liked" onclick="onActionClick('.$postid.')" id="button'.$postid.'" type="button" data-userpostid="'.$postid.'" data-action="unlike">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="#646464" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                    </path>
                                </svg>
                            </button>';
            } else {
                $likebutton = '<button class="button-icon--small" onclick="onActionClick('.$postid.')" id="button'.$postid.'" type="button" data-userpostid="'.$postid.'" data-action="like">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="#646464" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                    </path>
                                </svg>
                            </button>';
            }
            //query to get the name of the user not the username
            $res = mysqli_query($conn,"SELECT name FROM users WHERE userid=$userid");
            $content = mysqli_fetch_assoc($res);
            $name = htmlspecialchars($content['name']);
 			//query to get the profile image
 			$queryusername = mysqli_real_escape_string($conn,$username);
 			$sql = "SELECT profileimage FROM userprofileimg WHERE username="."'$queryusername'".";";
    		$res = mysqli_query($conn,$sql);
            if(mysqli_num_rows($res) != 1) {
                $userimage = '<img class="post__user-image" src="./assets/default_avatar.jpg">';
            } else {
            	$content = mysqli_fetch_assoc($res);
            	$profileimage = $content['profileimage'];
                $userimage = '<img class="post__user-image" src="./uploadprofile/'.$profileimage.'">';
            }
               //query to get all the content of a specific post 
            $result1 = mysqli_query($conn,"SELECT * FROM posts WHERE id=$postid AND userid=$userid");
            $content = mysqli_fetch_assoc($result1);
            $articlephoto = $content['link'];
            $output .= '<article class="post">
            <span class="post__topic">'.htmlspecialchars($content['tag']).'</span>
            <section class="post__header">'.
                $userimage
                .'<aside>
                    <h5 class="post__user"><a href="profile.php?user='.$username.'" style="text-decoration:none;color:inherit;">'.$name.'</a></h5>
                    <h6 class="post__timestamp">'.$content['dt'].'</h6>
                </aside>
                <button class="button-icon--small post__settings" onclick="showPostSettings(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#646464" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
            </section>
            <section class="post__settings-container">
                <aside class="post__setting-option">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                        </polygon>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12" y2="16"></line>
                    </svg>
                    <h3 class="post__setting-option-title reportButton" data-postid="'.$postid.'">Report this post</h3>
                </aside>
                <aside class="post__setting-option" onclick="hidePostSettings(this)">
                    <h3 class="post__setting-option-title" style="margin-left: 40px;">Cancel</h3>
                </aside>
            </section>
            <section class="post__body--article">
                <aside>
                    <p class="post__title">'.htmlspecialchars($content['title']).'</p>
                    <p class="post__preview--text">'.CheckMentions($content['caption']).'</p>
                </aside>';
                if($articlephoto != "") {
                    $output .='
                    <img class="post__cover" src="posts/'.$articlephoto.'" alt="">';
                }
                $output.='
            </section>
            <section class="post__footer">
                <aside  id="div'.$postid.'" class="post__footer-button class'.$postid.'">'.
                    $likebutton.'
                    <h6 class="post__footer-count">'.$content['likes'].'</h6>
                </aside>
                <aside class="post__footer-button">
                    <button class="button-icon--small">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="##646464" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </button>
                    <h6 class="post__footer-count">'.$content['comments'].'</h6>
                </aside>
            </section>
        </article>';
        }
        else if($content['type'] == 'video')  {
            $likebutton = "";
            $postid = $content['id'];
            $username = $content['username'];
            $userid = $content['userid'];
            $res = mysqli_query($conn,"SELECT * FROM likes WHERE postid=$postid AND likedby="."'$user'".";") or die("ERROR"); 
                
            if(mysqli_num_rows($res) == 1) {
                $likebutton = '<button class="button-icon--small post__liked" onclick="onActionClick('.$postid.')" id="button'.$postid.'" type="button" data-userpostid="'.$postid.'" data-action="unlike">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="#646464" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                    </path>
                                </svg>
                            </button>';
            } else {
                $likebutton = '<button class="button-icon--small" onclick="onActionClick('.$postid.')" id="button'.$postid.'" type="button" data-userpostid="'.$postid.'" data-action="like">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="#646464" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                    </path>
                                </svg>
                            </button>';
            }
            //query to get the name of the user not the username
            $res = mysqli_query($conn,"SELECT name FROM users WHERE userid=$userid");
            $content = mysqli_fetch_assoc($res);
            $name = htmlspecialchars($content['name']);
            //query to get the profile image
            $queryusername = mysqli_real_escape_string($conn,$username);
            $sql = "SELECT profileimage FROM userprofileimg WHERE username="."'$queryusername'".";";
            $res = mysqli_query($conn,$sql);
            if(mysqli_num_rows($res) != 1) {
                $userimage = '<img class="post__user-image" src="./assets/default_avatar.jpg">';
            } else {
                $content = mysqli_fetch_assoc($res);
                $profileimage = $content['profileimage'];
                $userimage = '<img class="post__user-image" src="./uploadprofile/'.$profileimage.'">';
            }
               //query to get all the content of a specific post 
            $result1 = mysqli_query($conn,"SELECT * FROM posts WHERE id=$postid AND userid=$userid");
            $content = mysqli_fetch_assoc($result1);
            $output .= '<article class="post">
            <span class="post__topic">'.htmlspecialchars($content['tag']).'</span>
            <section class="post__header">'.
                $userimage
                .'<aside>
                    <h5 class="post__user"><a href="profile.php?user='.$username.'" style="text-decoration:none;color:inherit;">'.$name.'</a></h5>
                    <h6 class="post__timestamp">'.$content['dt'].'</h6>
                </aside>
                <button class="button-icon--small post__settings" onclick="showPostSettings(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#646464" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
            </section>
            <section class="post__settings-container">
                <aside class="post__setting-option">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                        </polygon>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12" y2="16"></line>
                    </svg>
                    <h3 class="post__setting-option-title reportButton" data-postid="'.$postid.'">Report this post</h3>
                </aside>
                <aside class="post__setting-option" onclick="hidePostSettings(this)">
                    <h3 class="post__setting-option-title" style="margin-left: 40px;">Cancel</h3>
                </aside>
            </section>
            <section class="post__body">
                <p class="post__title">'.htmlspecialchars($content['title']).'</p>
                    <div class="post__media">
                        <iframe width="100%" height="240px" src="https://www.youtube.com/embed/'.htmlspecialchars($content['link']).'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>                     
            </section>
            <section class="post__footer">
                <aside  id="div'.$postid.'" class="post__footer-button class'.$postid.'">'.
                    $likebutton.'
                    <h6 class="post__footer-count">'.$content['likes'].'</h6>
                </aside>
                <aside class="post__footer-button">
                    <button class="button-icon--small">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="##646464" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </button>
                    <h6 class="post__footer-count">'.$content['comments'].'</h6>
                </aside>
            </section>
        </article>';
        }
        else if($content['type'] == 'photo')  {
            $likebutton = "";
            $postid = $content['id'];
            $username = $content['username'];
            $userid = $content['userid'];
            $res = mysqli_query($conn,"SELECT * FROM likes WHERE postid=$postid AND likedby="."'$user'".";") or die("ERROR"); 
                
            if(mysqli_num_rows($res) == 1) {
                $likebutton = '<button class="button-icon--small post__liked" onclick="onActionClick('.$postid.')" id="button'.$postid.'" type="button" data-userpostid="'.$postid.'" data-action="unlike">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="#646464" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                    </path>
                                </svg>
                            </button>';
            } else {
                $likebutton = '<button class="button-icon--small" onclick="onActionClick('.$postid.')" id="button'.$postid.'" type="button" data-userpostid="'.$postid.'" data-action="like">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="#646464" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                    </path>
                                </svg>
                            </button>';
            }
            //query to get the name of the user not the username
            $res = mysqli_query($conn,"SELECT name FROM users WHERE userid=$userid");
            $content = mysqli_fetch_assoc($res);
            $name = htmlspecialchars($content['name']);
            //query to get the profile image
            $queryusername = mysqli_real_escape_string($conn,$username);
            $sql = "SELECT profileimage FROM userprofileimg WHERE username="."'$queryusername'".";";
            $res = mysqli_query($conn,$sql);
            if(mysqli_num_rows($res) != 1) {
                $userimage = '<img class="post__user-image" src="./assets/default_avatar.jpg">';
            } else {
                $content = mysqli_fetch_assoc($res);
                $profileimage = $content['profileimage'];
                $userimage = '<img class="post__user-image" src="./uploadprofile/'.$profileimage.'">';
            }
               //query to get all the content of a specific post 
            $result1 = mysqli_query($conn,"SELECT * FROM posts WHERE id=$postid AND userid=$userid");
            $content = mysqli_fetch_assoc($result1);
            $post_image_name = htmlspecialchars($content['textbody']);
            $output .= '<article class="post">
            <span class="post__topic">'.htmlspecialchars($content['tag']).'</span>
            <section class="post__header">'.
                $userimage
                .'<aside>
                    <h5 class="post__user"><a href="profile.php?user='.$username.'" style="text-decoration:none;color:inherit;">'.$name.'</a></h5>
                    <h6 class="post__timestamp">'.$content['dt'].'</h6>
                </aside>
                <button class="button-icon--small post__settings" onclick="showPostSettings(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#646464" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
            </section>
            <section class="post__settings-container">
                <aside class="post__setting-option">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                        </polygon>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12" y2="16"></line>
                    </svg>
                    <h3 class="post__setting-option-title reportButton" data-postid="'.$postid.'">Report this post</h3>
                </aside>
                <aside class="post__setting-option" onclick="hidePostSettings(this)">
                    <h3 class="post__setting-option-title" style="margin-left: 40px;">Cancel</h3>
                </aside>
            </section>
            <section class="post__body">
                <p class="post__title">'.CheckMentions($content['caption']).'</p>
                    <div class="post__media">
                        <img class="post__media--photo" src="./posts/'.$post_image_name.'" alt="">
                    </div>
            </section>
            <section class="post__footer">
                <aside  id="div'.$postid.'" class="post__footer-button class'.$postid.'">'.
                    $likebutton.'
                    <h6 class="post__footer-count">'.$content['likes'].'</h6>
                </aside>
                <aside class="post__footer-button">
                    <button class="button-icon--small">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="##646464" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </button>
                    <h6 class="post__footer-count">'.$content['comments'].'</h6>
                </aside>
            </section>
        </article>';
        }
        else {
            $likebutton = "";
            $postid = $content['id'];
            $username = $content['username'];
            $userid = $content['userid'];
            $res = mysqli_query($conn,"SELECT * FROM likes WHERE postid=$postid AND likedby="."'$user'".";") or die("ERROR"); 
                
            if(mysqli_num_rows($res) == 1) {
                $likebutton = '<button class="button-icon--small post__liked" onclick="onActionClick('.$postid.')" id="button'.$postid.'" type="button" data-userpostid="'.$postid.'" data-action="unlike">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="#646464" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                    </path>
                                </svg>
                            </button>';
            } else {
                $likebutton = '<button class="button-icon--small" onclick="onActionClick('.$postid.')" id="button'.$postid.'" type="button" data-userpostid="'.$postid.'" data-action="like">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="#646464" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                    </path>
                                </svg>
                            </button>';
            }
            //query to get the name of the user not the username
            $res = mysqli_query($conn,"SELECT name FROM users WHERE userid=$userid");
            $content = mysqli_fetch_assoc($res);
            $name = htmlspecialchars($content['name']);
            //query to get the profile image
            $queryusername = mysqli_real_escape_string($conn,$username);
            $sql = "SELECT profileimage FROM userprofileimg WHERE username="."'$queryusername'".";";
            $res = mysqli_query($conn,$sql);
            if(mysqli_num_rows($res) != 1) {
                $userimage = '<img class="post__user-image" src="./assets/default_avatar.jpg">';
            } else {
                $content = mysqli_fetch_assoc($res);
                $profileimage = $content['profileimage'];
                $userimage = '<img class="post__user-image" src="./uploadprofile/'.$profileimage.'">';
            }
               //query to get all the content of a specific post 
            $result1 = mysqli_query($conn,"SELECT * FROM posts WHERE id=$postid AND userid=$userid");
            $content = mysqli_fetch_assoc($result1);
            $home_photos_string=$content['textbody'];
            $home_photos_array=explode(" ", $home_photos_string);
            $output .= '
            <article class="post">
            <span class="post__topic">'.htmlspecialchars($content['tag']).'</span>
            <section class="post__header">'.
                $userimage
                .'<aside>
                    <h5 class="post__user"><a href="profile.php?user='.$username.'" style="text-decoration:none;color:inherit;">'.$name.'</a></h5>
                    <h6 class="post__timestamp">'.$content['dt'].'</h6>
                </aside>
                <button class="button-icon--small post__settings" onclick="showPostSettings(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#646464" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
            </section>
            <section class="post__settings-container">
                <aside class="post__setting-option">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                        </polygon>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12" y2="16"></line>
                    </svg>
                    <h3 class="post__setting-option-title reportButton" data-postid="'.$postid.'">Report this post</h3>
                </aside>
                <aside class="post__setting-option" onclick="hidePostSettings(this)">
                    <h3 class="post__setting-option-title" style="margin-left: 40px;">Cancel</h3>
                </aside>
            </section>
            <section class="post__body">
                <p class="post__title">'.CheckMentions($content['caption']).'</p>
                    <div class="post__media">
                        <img class="post__media--photo" src="./posts/'.$home_photos_array[0].'" alt="">
                        <div class="post__media--photo-more"><span>'.$content['link'].'</span></div>
                    </div>               
            </section>
            <section class="post__footer">
                <aside  id="div'.$postid.'" class="post__footer-button class'.$postid.'">'.
                    $likebutton.'
                    <h6 class="post__footer-count">'.$content['likes'].'</h6>
                </aside>
                <aside class="post__footer-button">
                    <button class="button-icon--small">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="##646464" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </button>
                    <h6 class="post__footer-count">'.$content['comments'].'</h6>
                </aside>
            </section>
            </article>';
        }
    }
    echo $output;
} else {
    //no posts.
}

?>