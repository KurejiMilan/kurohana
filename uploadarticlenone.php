<?php
include ("includefiles/header.inc.php");
$id=0;
$username=$_SESSION['user'];
$sql="SELECT userid FROM users WHERE username="."'$username'".";";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)==1){
    $content=mysqli_fetch_assoc($result);
    $id=$content['userid'];  
    $title=mysqli_real_escape_string($conn,$_POST["titleinput"]);
    $caption=mysqli_real_escape_string($conn,$_POST["subtitleinput"]);
    $textbody=mysqli_real_escape_string($conn,$_POST["bodytextarea"]);
    $tag=mysqli_real_escape_string($conn,$_POST["tag"]);
    $visibility = mysqli_real_escape_string($conn, $_POST['audience']);
    $date=date("Y:m:d");
    $type="article";
    $name="";
    $sql="INSERT INTO posts(id,userid,username,title,caption,link,textbody,tag,dt,type,visibility) VALUES('','$id','$username','$title','$caption','$name','$textbody','$tag','$date','$type','$visibility');";
    mysqli_query($conn,$sql) or die("ERROR!");
    $recentInsertId = mysqli_insert_id($conn);
    insertPost($recentInsertId, $title, "", "post_article"); 	
}
?>
