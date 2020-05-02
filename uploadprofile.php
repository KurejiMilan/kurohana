<?php
include ("includefiles/header.inc.php");
$id=0;
$username=$user;
$username=mysqli_real_escape_string($conn,$username);
$sql="SELECT userid FROM users WHERE username="."'$username'".";";
$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)==1)
 	{
		 $content=mysqli_fetch_assoc($result);
		 $id=$content['userid'];

		if($_FILES["file"]["name"] != '')
		{
 			$test = explode('.', $_FILES["file"]["name"]);
 			$ext = end($test);
 			$name = $username.$id. '.' . $ext;
 			$name=mysqli_real_escape_string($conn,$name);
 			$location = './uploadprofile/' . $name; 
   				if (file_exists($location))  
    				{  
     					unlink($location);
	 					move_uploaded_file($_FILES["file"]["tmp_name"], $location);
	 					$sql="UPDATE userprofileimg SET profileimage="."'$name'"." WHERE userid='$id' AND username="."'$username'".";";
	 					mysqli_query($conn,$sql);
    				}    
 				else
    				{
	 					move_uploaded_file($_FILES["file"]["tmp_name"], $location);
	 					$sql="SELECT id FROM userprofileimg WHERE userid='$id' AND username="."'$username'".";";
	 					$result=mysqli_query($conn,$sql);
	  					if (mysqli_num_rows($result)==1)
	   					{
		 				$sql="UPDATE userprofileimg SET profileimage="."'$name'"." WHERE userid='$id' AND username="."'$username'".";";
		 				mysqli_query($conn,$sql); 
	   					}
	 			 		else
	  					{   
	    				$sql="INSERT INTO userprofileimg(id,userid,username,profileimage) VALUES('','$id','$username','$name');";
	    				mysqli_query($conn,$sql);
	  					}
					}
		}
		$sql="SELECT profileimage FROM userprofileimg WHERE username="."'$username'".";";
		$result=mysqli_query($conn,$sql);
     	if(mysqli_num_rows($result)==1)
     	{
          $content=mysqli_fetch_assoc($result);
		  $name=$content['profileimage'];
			//  echo '		 
		 	// <img id="form__profile-img" src="./uploadprofile/'.$name.'" alt="avatar" />
		 	// <input id="input__file-select" type="file" >		 
			//  ';
			echo 'Success';
	 	}
 	}
?>

