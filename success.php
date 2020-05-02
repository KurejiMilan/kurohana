<?php
include ("includefiles/header.inc.php");
$sql="SELECT profileimage FROM userprofileimg WHERE username="."'$user'".";";
$result=mysqli_query($conn,$sql);
     if(mysqli_num_rows($result)==1)
     {
          $content=mysqli_fetch_assoc($result);
		  $name=$content['profileimage'];
		 echo '		 
		 <img id="form__profile-img" src="./uploadprofile/'.$name.'" alt="avatar" />		 
		 ';
	 }
	 else
	 {
		 echo $_SESSION['user'];
		 echo "ERROR!";
	 }
?>
