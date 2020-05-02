<?php
require('./includefiles/header.inc.php');

$id=0;
$type="video";
$qusername=mysqli_real_escape_string($conn,$user);
$title=mysqli_real_escape_string($conn,$_POST['title']);
$tag=mysqli_real_escape_string($conn,$_POST['tag']);
$description=mysqli_real_escape_string($conn,$_POST['description']);
$visibility = mysqli_real_escape_string($conn, $_POST['audience']);
$date=date("Y:m:d");
$link =$_POST['link'];
$caption="";
    //algorithm to get the video name
	 if(strpos($link,'=') !== false){
     	$array=explode('=',$link);
     		if(count($array)>2){
          		$link=$array[1];
          		$link=explode('&', $link);
          		$videourl= $link[0]; 
     		}else{
     	  		$link=explode('=',$link);
          		$videourl= end($link); 
     		} 
	 }else{
 		   $link=explode('/', $link);
    	 $videourl = end($link);
	 }
$result=mysqli_query($conn,"SELECT userid FROM users WHERE username="."'$qusername'".";");
  if(mysqli_num_rows($result)== 1){
      $content=mysqli_fetch_assoc($result);
      $id=$content['userid'];
      $sql="INSERT INTO posts(id,userid,username,title,caption,link,textbody,tag,dt,type,visibility) VALUES('','$id','$qusername','$title','$caption','$videourl','$description','$tag','$date','$type','$visibility');";        
      mysqli_query($conn,$sql) or die("ERROR!");
      $recentInsertId = mysqli_insert_id($conn);
      insertPost($recentInsertId, $title, $caption,"post_video");     
  }
?>