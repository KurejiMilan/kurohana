<?php
include ("Database.inc.php");
mysqli_set_charset($conn, "utf8mb4");
session_start();
 if(isset($_SESSION['user'])){
	$user=$_SESSION["user"];	
 }else{
	 $user="";
 }
global $conn;


function insertName($userid, $username, $name){
    global $conn;
    $sql = "INSERT INTO search (search_id, usernameORtitle, nameORcaption, type) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $sql)){
        $username = metaphone($username);
        $name = metaphone($name);
        $type = 'profile';
        mysqli_stmt_bind_param($stmt, "isss", $userid, $username, $name, $type);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

function insertPost($id, $title, $caption, $type){
    global $conn;
    $title = metaphone($title);
    $caption = metaphone($caption);
    $sql = "INSERT INTO search (search_id, usernameORtitle, nameORcaption, type) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt, "isss", $id, $title, $caption, $type);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

//this is new part, mention script
// convertlinks and checkMentions are to link the tagged users
function convertLinks($link)
{
	global $conn;
	if(strpos($link,"@")!==false){
    	$startpos=strpos($link, "@");
    	$linkchecked="";//this hold the string which has been coverted to link
    	$bool=false;//this is not a good name for a varaiable i know
    	if($startpos!=0)
    	{
    		$count=0;
    		$newlink=substr($link,$startpos);
        	$linkchecked=htmlspecialchars(substr($link,0,$startpos));
        	$startpos=0;
        	$strlen=strlen($link)-strlen($linkchecked);
        	while($bool===false)
        	{
        		if($startpos===$strlen)
        		{
        		 $bool=true;
                 return $linkchecked.'@'.convertLinks(substr($newlink,1));
        		}
        		$temUsername=substr($newlink,$startpos+1,$strlen-1);
        		$query_username=mysqli_real_escape_string($conn,$temUsername);
        		$result=mysqli_query($conn,"SELECT * FROM users WHERE username="."'$query_username'".";") or die("couldn't do query");
        		if(mysqli_num_rows($result)===1)
        		{	
        			$linkchecked.='<a href="profile.php?user='.$query_username.'" style="color:black;font-weight:bold;">@'.$query_username.'</a>';
        			$bool=true;
        		}
                $strlen-=1;
               
        	}
        	
        	return $linkchecked.convertLinks(substr($newlink,$strlen+1));
    	}
    	else
    	{
    		$strlen=strlen($link);
        	while($bool===false)
        	{
        		if($startpos===$strlen-1)
        		{
        		 $bool=true;
                 return $linkchecked.'@'.convertLinks(substr($link,1));
        		}
        		$temUsername=substr($link,$startpos+1,$strlen-1);
        		$query_username=mysqli_real_escape_string($conn,$temUsername);
        		$result=mysqli_query($conn,"SELECT * FROM users WHERE username="."'$query_username'".";");
        		if(mysqli_num_rows($result)===1)
        		{	
        			$linkchecked.='<a href="profile.php?user='.$query_username.'" style="color:black;font-weight:bold;">@'.$query_username.'</a>';
        			$bool=true;
        		}
                --$strlen;
        	}
   
        	return $linkchecked.convertLinks(substr($link,$strlen+1));
    	}
	}
	else{
		return htmlspecialchars($link);
	}
}

function CheckMentions($string) 
{
	$array=explode(" ", $string);
	$arrayelement=count($array);
	for($i=0;$i<$arrayelement;$i++)
 	{
 		if(strpos($array[$i],"@")!==false)
 		{
      		$array[$i]=convertLinks($array[$i]);
 		}
 		else
 		{
 			$array[$i]=htmlspecialchars($array[$i]);
 		}
 	}
	$string=implode(" ",$array);
	return $string;
}

//convertLinks_insert and CheckMentions_insert are to notify the tagged users
function convertLinks_insert($link,$postID)
{
	global $conn;
	$user=$GLOBALS['$user'];
	if(strpos($link,"@")!==false){
    	$startpos=strpos($link, "@");
    	$linkchecked="";//this hold the string which has been coverted to link
    	$bool=false;//this is not a good name for a varaiable i know
    	if($startpos!=0)
    	{
    		$count=0;
    		$newlink=substr($link,$startpos);
        	$linkchecked=htmlspecialchars(substr($link,0,$startpos));
        	$startpos=0;
        	$strlen=strlen($link)-strlen($linkchecked);
        	while($bool===false)
        	{
        		if($startpos===$strlen)
        		{
        		 $bool=true;
                 return $linkchecked.'@'.convertLinks(substr($newlink,1));
        		}
        		$temUsername=substr($newlink,$startpos+1,$strlen-1);
        		$query_username=mysqli_real_escape_string($conn,$temUsername);
        		$result=mysqli_query($conn,"SELECT * FROM users WHERE username="."'$query_username'".";") or die("couldn't do query");
        		if(mysqli_num_rows($result)===1)
        		{	
        			$date= date("Y-m-d");
        			$seen=false;
        			mysqli_query($conn,"INSERT INTO notification(id,name,notification,link,dt,seen,postid) VALUES('','$query_username','mentioned you.','$user','$date','$seen','$postID')") or die("couldn't do the notification query");
        			$bool=true; 
        		}
                $strlen-=1;
               
        	}
        	
        	return $linkchecked.convertLinks(substr($newlink,$strlen+1));
    	}
    	else
    	{
    		$strlen=strlen($link);
        	while($bool===false)
        	{
        		if($startpos===$strlen-1)
        		{
        		 $bool=true;
                 return $linkchecked.'@'.convertLinks(substr($link,1));
        		}
        		$temUsername=substr($link,$startpos+1,$strlen-1);
        		$query_username=mysqli_real_escape_string($conn,$temUsername);
        		$result=mysqli_query($conn,"SELECT * FROM users WHERE username="."'$query_username'".";");
        		if(mysqli_num_rows($result)===1)
        		{	
        			$date= date("Y-m-d");
        			$seen=false;
        			mysqli_query($conn,"INSERT INTO notification(id,name,notification,link,dt,seen,postid) VALUES('','$query_username','mentioned you.','$user','$date','$seen','$postID')") or die("couldn't do the notification query");
        			$bool=true;
        		}
                --$strlen;
        	}
   
        	return $linkchecked.convertLinks(substr($link,$strlen+1));
    	}
	}
	else{
		return htmlspecialchars($link);
	}
}

function CheckMentions_insert($string,$postID) 
{
	$array=explode(" ", $string);
	$arrayelement=count($array);
	for($i=0;$i<$arrayelement;$i++)
 	{
 		if(strpos($array[$i],"@")!==false)
 		{
      		$array[$i]=convertLinks_insert($array[$i],$postID);
 		}
 		else
 		{
 			$array[$i]=htmlspecialchars($array[$i]);
 		}
 	}
	$string=implode(" ",$array);
	return $string;
}  
?>