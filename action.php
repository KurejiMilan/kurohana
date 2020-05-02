<?php
include('./includefiles/header.inc.php');
 
 if($_POST['action'] == 'fetch_notification')
{ 
    $LIMIT=$_POST['count'];
    $loadmore=false;
    $output="";
    $sql="SELECT * FROM notification WHERE name="."'$user'"."ORDER BY id DESC LIMIT $LIMIT;";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0)
   {
      $newresult=mysqli_query($conn,"SELECT * FROM notification WHERE name="."'$user'".";");
      if(mysqli_num_rows($newresult)>$LIMIT)
        {$loadmore=true;}
        $rows=mysqli_fetch_all($result,MYSQLI_ASSOC);
   	  foreach($rows as $content)
   	  {  	 
   	      $btn="";
            if($content['notification']==='started following you.')
        {
       	$newfollower=$content['link'];
        $date=$content['dt'];
        $result=mysqli_query($conn,"SELECT profileimage FROM userprofileimg WHERE username="."'$newfollower'".";");
        if(mysqli_num_rows($result)==1){
          $content=mysqli_fetch_assoc($result); 
          $follower_profile_img=$content['profileimage'];
          $img='<img class="notification__img" src="./uploadprofile/'.$follower_profile_img.'" alt="follower_profile_img">';
        }
        else
         {$img='<img class="notification__img" src="./assets/default_avatar.jpg" alt="follower_profile_img">';}    
   	   
   	    $result=mysqli_query($conn,"SELECT * FROM follow WHERE following="."'$newfollower'"."AND followedby="."'$user'".";");
   	    
   	    if(mysqli_num_rows($result)==1)
   	    {
          $btn='
                <button class="notification__btn--follow followed-back" id="action_button" name="unfollow" type="button" data-action="unfollow" data-follower="'.$newfollower.'">
                    <svg class="not-following" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="#646464" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                    <svg class="following" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <polyline points="17 11 19 13 23 9"></polyline>
                    </svg>
                </button>
          ';
   	    }
   	    else {
          $btn='
            <button class="notification__btn--follow " id="action_button" name="follow" type="button" data-action="follow" 
            data-follower="'.$newfollower.'">
                    <svg class="not-following" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="#646464" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                    <svg class="following" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <polyline points="17 11 19 13 23 9"></polyline>
                    </svg>
                </button>
          ';
   	    }

   	  $output .='
    	<article class="notification">
                '.$img.'
                <section class="notification__body">
                    <h4 class="notification__message"><b>'.$newfollower.'</b> started following you.</h4>
                    <h6 class="notification__timestamp">'.$date.'</h6>
                </section>
                '.$btn.'               
        </article>
   	';
   	 }
      else if($content['notification']==='liked your post.')
      {
        $likedby=$content['link'];
        $date=$content['dt'];
        $res=mysqli_query($conn,"SELECT profileimage FROM userprofileimg WHERE username="."'$likedby'".";");
        if(mysqli_num_rows($res)==1)
        {
          $content=mysqli_fetch_assoc($res); 
          $likedby_img=$content['profileimage'];
          $img='<img class="notification__img" src="uploadprofile/'.$likedby_img.'" alt="">';
        }
        else
         {
          $img='<img class="notification__img" src="./assets/default_avatar.jpg" alt="">';
         }  
          $output.='<article class="notification">
                    '.$img.'
                    <section class="notification__body">
                        <h4 class="notification__message"><b>'.$likedby.'</b> liked your post.</h4>
                        <h6 class="notification__timestamp">'.$date.'</h6>
                    </section>
                </article>';
      }
   	 //for different notification
    }
     if($loadmore==true)
     {
      $output .='
        <button class="button-text--secondary notification-load-more" id="btn-load-more">Load More</button>
      ';
     }
     echo $output;
 }

 else
    {
      echo '<span class="empty-state__notification">No Notification</span>';
    }
}


 if($_POST['action'] == 'follow')
 {
   $follower=htmlspecialchars($_POST['follower']);
   $bool=false;
   $zero=0;
   $date=date("Y-m-d");
	  $result=mysqli_query($conn,"SELECT * FROM follow WHERE following="."'$follower'"." AND followedby="."'$user'".";");
	  if(mysqli_num_rows($result)==0)
	  {
	  $sql="INSERT INTO follow(id,following,followedby) VALUES('','$follower','$user')";
      mysqli_query($conn,$sql) or die("couldn't follow query");
	  $result=mysqli_query($conn,"SELECT followers FROM users WHERE username="."'$follower'".";") or die("error203!");
	  $content=mysqli_fetch_assoc($result);
	  $followers=$content['followers'];
	  $followers+=1;
	  $result=mysqli_query($conn,"SELECT following FROM users WHERE username="."'$user'".";") or die("error!");
	  $content=mysqli_fetch_assoc($result);
	  $followingnum=$content['following'];
	  $followingnum+=1;
	  mysqli_query($conn,"UPDATE users SET followers=".$followers." WHERE username="."'$follower'".";") or die("can not query the followers number");
	  mysqli_query($conn,"UPDATE users SET following=".$followingnum." WHERE username="."'$user'".";") or die("can not query the following number");  
	  mysqli_query($conn,"INSERT INTO notification(id,name,notification,link,dt,seen,postid) VALUES('','$follower','started following you.','$user','$date','$bool','$zero')") or die("couldn'nt do the notification query");
	  }
 }


 if($_POST['action'] == 'unfollow')
 {
  $follower=htmlspecialchars($_POST['follower']);

	  $result=mysqli_query($conn,"SELECT * FROM follow WHERE following="."'$follower'"." AND followedby="."'$user'".";");
	  if(mysqli_num_rows($result)==1)
	  {
	  $sql="DELETE FROM follow WHERE following="."'$follower'"." AND followedby="."'$user'".";";
	  mysqli_query($conn,$sql) or die("couldn't unfollow query");
	  $result=mysqli_query($conn,"SELECT followers FROM users WHERE username="."'$follower'".";") or die("error203!");
	  $content=mysqli_fetch_assoc($result);
	  $followers=$content['followers'];
	  $followers-=1;
      $result=mysqli_query($conn,"SELECT following FROM users WHERE username="."'$user'".";");
	  $content=mysqli_fetch_assoc($result);
	  $followingnum=$content['following'];
	  $followingnum-=1;
	  mysqli_query($conn,"UPDATE users SET followers=".$followers." WHERE username="."'$follower'".";") or die("can not query the followers number");
	  mysqli_query($conn,"UPDATE users SET following=".$followingnum." WHERE username="."'$user'".";") or die("can not query the following number");
	  }
 }

 if($_POST['action']=='followuser')
 {
    $username=htmlspecialchars($_POST['username']);
      $date=date("Y-m-d");
      $bool=false;
      $zero=0;
      $result=mysqli_query($conn,"SELECT * FROM follow WHERE following="."'$username'"." AND followedby="."'$user'".";");
      if(mysqli_num_rows($result)==0)
      {
      $sql="INSERT INTO follow(id,following,followedby) VALUES('','$username','$user')";
      mysqli_query($conn,$sql) or die("couldn't follow query");
      $result=mysqli_query($conn,"SELECT followers FROM users WHERE username="."'$username'".";") or die("error203!");
      $content=mysqli_fetch_assoc($result);
      $followers=$content['followers'];
      $followers+=1;
      $result=mysqli_query($conn,"SELECT following FROM users WHERE username="."'$user'".";") or die("error!");
      $content=mysqli_fetch_assoc($result);
      $followingnum=$content['following'];
      $followingnum+=1;
      mysqli_query($conn,"UPDATE users SET followers=".$followers." WHERE username="."'$username'".";") or die("can not query the followers number");
      mysqli_query($conn,"UPDATE users SET following=".$followingnum." WHERE username="."'$user'".";") or die("can not query the following number");  
      mysqli_query($conn,"INSERT INTO notification(id,name,notification,link,dt,seen,postid) VALUES('','$username','started following you.','$user','$date','$bool','$zero')") or die("couldn'nt do the notification query");
      }
     
    echo 
    '<button class="button-filled--primary" type="button" id="follow_button" name="unfollow" data-action="unfollowuser" data-username="'.$username.'">Following</button>';
 }

 if($_POST['action']=='unfollowuser')
 {
    $username=htmlspecialchars($_POST['username']);
    $result=mysqli_query($conn,"SELECT * FROM follow WHERE following="."'$username'"." AND followedby="."'$user'".";");
      if(mysqli_num_rows($result)==1)
      {
      $sql="DELETE FROM follow WHERE following="."'$username'"." AND followedby="."'$user'".";";
      mysqli_query($conn,$sql) or die("couldn't unfollow query");
      $result=mysqli_query($conn,"SELECT followers FROM users WHERE username="."'$username'".";") or die("error203!");
      $content=mysqli_fetch_assoc($result);
      $followers=$content['followers'];
      $followers-=1;
      $result=mysqli_query($conn,"SELECT following FROM users WHERE username="."'$user'".";");
      $content=mysqli_fetch_assoc($result);
      $followingnum=$content['following'];
      $followingnum-=1;
      mysqli_query($conn,"UPDATE users SET followers=".$followers." WHERE username="."'$username'".";") or die("can not query the followers number");
      mysqli_query($conn,"UPDATE users SET following=".$followingnum." WHERE username="."'$user'".";") or die("can not query the following number");
      }
     echo '<button class="button-outlined" type="button" id="follow_button" name="follow" data-action="followuser" data-username="'.$username.'">Follow</button>';
 }

 if($_POST['action']=='fetch_new_notification_num')
 {
    $result=mysqli_query($conn,"SELECT * FROM notification WHERE name="."'$user'"."AND seen=0;");
    $num=mysqli_num_rows($result);
    if(($num>0)&&($num<11)){
     echo $num;
    }
    else if($num>=11){
     echo "+10";
    }
    else
     echo"";     
 }

 if($_POST['action']=='update_notification_num')
 {
    mysqli_query($conn,"UPDATE notification SET seen=1 WHERE name="."'$user'".";")or die("couldn't update the notification number!");
 }
 
 if($_POST['action']=='updatelikebutton'){
  $postid=mysqli_real_escape_string($conn,$_POST['postid']);
  $method=htmlspecialchars($_POST['method']);
  
  if($method=="like"){
  $seen=false;
  $date=date("Y-m-d");
  $result=mysqli_query($conn,"SELECT likes,username FROM posts WHERE id=$postid;") or die("ERROR!");
  $content=mysqli_fetch_assoc($result);
  $num=$content['likes'];
  $username=$content['username'];
  $num+=1;
  mysqli_query($conn,"UPDATE posts SET likes=$num WHERE id=$postid") or die("ERROR!");
  mysqli_query($conn,"INSERT INTO likes(id,postid,likedby,dt) VALUES('','$postid','$user','$date')") or die("ERROR!");
  if($username!=$user)
  {
  mysqli_query($conn,"INSERT INTO notification(id,name,notification,link,dt,seen,postid) VALUES('','$username','liked your post.','$user','$date','$seen','$postid')") or die("couldn'nt do the notification query");
  }

  $likebutton='
          <button class="button-icon--small post__liked" id="button'.$postid.'" onclick="onActionClick('.$postid.')" type="button" data-userpostid="'.$postid.'" data-action="unlike">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="#646464" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                </path>
                            </svg>
                        </button><h6 class="post__footer-count">'.$num.'</h6>';
  echo $likebutton;           
  }
  if($method=="unlike"){
  $result=mysqli_query($conn,"SELECT likes,username FROM posts WHERE id=$postid;") or die("ERROR!");
  $content=mysqli_fetch_assoc($result);
  $num=$content['likes'];
  $username=$content['username'];
  $num-=1;
  mysqli_query($conn,"UPDATE posts SET likes=$num WHERE id=$postid") or die("ERROR!");
  mysqli_query($conn,"DELETE FROM likes WHERE postid=$postid") or die("ERROR!");
         $likebutton='
            <button class="button-icon--small" id="button'.$postid.'" type="button" onclick="onActionClick('.$postid.')" data-userpostid="'.$postid.'" data-action="like">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="#646464" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                </path>
                            </svg>
                        </button><h6 class="post__footer-count">'.$num.'</h6>';
  echo $likebutton;
 }
 }
?>