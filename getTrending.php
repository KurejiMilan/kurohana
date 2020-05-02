<?php
include ('./includefiles/header.inc.php');
$trending_post="";
$date= array();

for ($i = 0;$i <= 4; $i++){
  $date[$i]=date('Y-m-d', strtotime('-'.$i.' days'));
}
$result=mysqli_query($conn,"SELECT * FROM posts WHERE dt='$date[0]' OR dt='$date[1]' OR dt='$date[2]'  OR dt='$date[3]' OR dt='$date[4]' ORDER BY likes DESC;"); 
if(mysqli_num_rows($result)>0){
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
            $trending_post .= '
         			<article class="post--trending">
                        <span class="post__topic">'.htmlspecialchars($content['tag']).'</span>
                        <section class="post__header">'.
                            $userimage
                            .'<aside>
                                <h5 class="post__user">'.$name.'</h5>
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
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                <h3 class="post__setting-option-title">Edit Post</h3>
                            </aside>
                            <aside class="post__setting-option">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                    </polygon>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12" y2="16"></line>
                                </svg>
                                <h3 class="post__setting-option-title">Report</h3>
                            </aside>
                            <aside class="post__setting-option">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                    </path>
                                </svg>
                                <h3 class="post__setting-option-title">Delete Post</h3>
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
                                $trending_post .='
                                <img class="post__cover--trending" src="posts/'.$articlephoto.'" alt="">';
                            }
                        $trending_post .='
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
        } else if($content['type'] == 'video')  {
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
            $trending_post .= '
        	<article class="post--trending">
                    <span class="post__topic">'.htmlspecialchars($content['tag']).'</span>
                        <section class="post__header">'.$userimage.'
                            <aside>
                                <h5 class="post__user">'.$name.'</h5>
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
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                <h3 class="post__setting-option-title">Edit Post</h3>
                            </aside>
                            <aside class="post__setting-option">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                    </polygon>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12" y2="16"></line>
                                </svg>
                                <h3 class="post__setting-option-title">Report</h3>
                            </aside>
                            <aside class="post__setting-option">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                <h3 class="post__setting-option-title">Delete Post</h3>
                            </aside>
                            <aside class="post__setting-option" onclick="hidePostSettings(this)">
                                <h3 class="post__setting-option-title" style="margin-left: 40px;">Cancel</h3>
                            </aside>
                        </section>
                        <section class="post__body">
                            <div class="post__media">        
                                <iframe width="100%" height="240px" src="https://www.youtube.com/embed/'.htmlspecialchars($content['link']).'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <p class="post__media--title">'.htmlspecialchars($content['textbody']).'</p>
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
                </article>
            ';
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
            $trending_post .= '
           		<article class="post--trending">
                    <span class="post__topic">'.htmlspecialchars($content['tag']).'</span>
                    <section class="post__header">'.$userimage.'
                        <aside>
                            <h5 class="post__user">'.$name.'</h5>
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
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            <h3 class="post__setting-option-title">Edit Post</h3>
                        </aside>
                        <aside class="post__setting-option">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                </polygon>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12" y2="16"></line>
                            </svg>
                            <h3 class="post__setting-option-title">Report</h3>
                        </aside>
                        <aside class="post__setting-option">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                </path>
                            </svg>
                            <h3 class="post__setting-option-title">Delete Post</h3>
                        </aside>
                        <aside class="post__setting-option" onclick="hidePostSettings(this)">
                            <h3 class="post__setting-option-title" style="margin-left: 40px;">Cancel</h3>
                        </aside>
                    </section>
                    <section class="post__body">
                        <div class="post__media">
                            <img class="post__media--photo" src="./posts/'.$content['textbody'].'" alt="">
                        </div>
                        <p class="post__media--title">'.CheckMentions($content['caption']).'</p>
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
                </article>
            ';
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
            $trending_photos_string=$content['textbody'];
            $trending_photos_array=explode(" ", $trending_photos_string);
            $trending_post .= '
                <article class="post--trending">
                    <span class="post__topic">'.htmlspecialchars($content['tag']).'</span>
                    <section class="post__header">'.$userimage.'
                        <aside>
                            <h5 class="post__user">'.$name.'</h5>
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
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            <h3 class="post__setting-option-title">Edit Post</h3>
                        </aside>
                        <aside class="post__setting-option">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                </polygon>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12" y2="16"></line>
                            </svg>
                            <h3 class="post__setting-option-title">Report</h3>
                        </aside>
                        <aside class="post__setting-option">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                </path>
                            </svg>
                            <h3 class="post__setting-option-title">Delete Post</h3>
                        </aside>
                        <aside class="post__setting-option" onclick="hidePostSettings(this)">
                            <h3 class="post__setting-option-title" style="margin-left: 40px;">Cancel</h3>
                        </aside>
                    </section>
                    <section class="post__body">
                        <div class="post__media">
                            <img class="post__media--photo" src="./posts/'.htmlspecialchars($trending_photos_array[0]).'" alt="">
                            <div class="post__media--photo-more"><span>'.htmlspecialchars($content['link']).'</span></div>
                        </div>
                        <p class="post__media--title">'.CheckMentions($content['caption']).'</p>
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
                </article>
            ';
        }
	}
	echo $trending_post;
}else{
	echo '
	<article class="post--trending">
	<p>    No trending posts.</p>
	</article>';
}?>
