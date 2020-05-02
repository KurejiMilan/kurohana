<?php
include("includefiles/header.inc.php");
	$sql = "SELECT username FROM users;";
	$result = mysqli_query($conn, $sql);
	$contents = mysqli_fetch_all($result, MYSQLI_ASSOC);
	//var_dump($contents);
	foreach ($contents as $content) {
		//echo $content['username'];
		$username = $content['username'];
		$sql = "INSERT INTO settings(id, username, likes, comments) VALUES('', '$username', true, true);";
		if(mysqli_query($conn, $sql)){
			echo "settings updated for user = ".$username."<hr><br>";
		}else{
			echo "settings updatig failed for user = ".$username."<hr><br>";		
		}
	}
?>