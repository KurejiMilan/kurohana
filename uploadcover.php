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
 			$location = './coverimage/' . $name; 
   				if (file_exists($location))  
    				{  
     					unlink($location);
	 					move_uploaded_file($_FILES["file"]["tmp_name"], $location);
	 					$sql="UPDATE coverimage SET coverimage="."'$name'"." WHERE userid='$id' AND username="."'$username'".";";
	 					mysqli_query($conn,$sql);
    				}    
 				else
    				{
	 					move_uploaded_file($_FILES["file"]["tmp_name"], $location);
	 					$sql="SELECT id FROM coverimage WHERE userid='$id' AND username="."'$username'".";";
	 					$result=mysqli_query($conn,$sql);
	  					if (mysqli_num_rows($result)==1)
	   					{
		 				$sql="UPDATE coverimage SET coverimage="."'$name'"." WHERE userid='$id' AND username="."'$username'".";";
		 				mysqli_query($conn,$sql); 
	   					}
	 			 		else
	  					{   
	    				$sql="INSERT INTO coverimage(id,userid,username,coverimage) VALUES('','$id','$username','$name');";
	    				mysqli_query($conn,$sql);
	  					}
					}
		}
		$sql="SELECT coverimage FROM coverimage WHERE username="."'$username'".";";
		$result=mysqli_query($conn,$sql);
     	if(mysqli_num_rows($result)==1)
     	{
          $content=mysqli_fetch_assoc($result);
		  $cover_image_name=$content['coverimage'];
			//  echo '
			//  <img id="cover-img" src="./coverimage/'.$cover_image_name.'" alt="default cover"/>
			//  <input id="coverimage--upload" type="file">
			//  ';
			echo "Success";
	 	}
 	}
?>
