<?php
include_once('./includefiles/header.inc.php');
	print('//*****Users search*****//');
	echo '<br>';
	$sql = "SELECT userid, username, name FROM 	users;";
	$result = mysqli_query($conn, $sql);
	$contents = mysqli_fetch_all($result, MYSQLI_ASSOC);

	foreach ($contents as $content) {
		$username = metaphone($content['username']);
		$name = metaphone($content['name']);
		$userid = $content['userid'];

			$sql_query = "INSERT INTO search (id, search_id, usernameORtitle, nameORcaption, type) VALUES('','$userid','$username','$name', 'profile');";
			$result = mysqli_query($conn, $sql_query);
				if($result == true){
					echo ($username).' //-----// '.($name).'  --success<br>';
				}
	}
	echo '<br><br><br>';
	print('//*****Posts search*****//');
	echo '<br>';
	$sql = "SELECT id, title, caption, type FROM posts;";
	$result = mysqli_query($conn, $sql);
	$contents = mysqli_fetch_all($result, MYSQLI_ASSOC);

	foreach ($contents as $content) {
		$content_id = $content['id'];
		$title = metaphone($content['title']);
		$caption = metaphone($content['caption']);

		if($content['type'] == "article"){
			$sql_query = "INSERT INTO search (id, search_id, usernameORtitle, nameORcaption, type) VALUES('', '$content_id', '$title', '$caption', 'post_article');";
			$result = mysqli_query($conn, $sql_query);
				if($result == true){
					echo ($title).' //-----// '.($caption).'  --success<br>';
				}
		}elseif($content['type'] == "video"){
			$sql_query = "INSERT INTO search (id, search_id, usernameORtitle, nameORcaption, type) VALUES('', '$content_id', '$title', '$caption', 'post_video');";
			$result = mysqli_query($conn, $sql_query);
				if($result == true){
					echo ($title).' //-----// '.($caption).'  --success<br>';
				}
		}elseif($content['type'] == "photo"){
			$sql_query = "INSERT INTO search (id, search_id, usernameORtitle, nameORcaption, type) VALUES('', '$content_id', '$title', '$caption', 'post_photo');";
			$result = mysqli_query($conn, $sql_query);
				if($result == true){
					echo ($title).' //-----// '.($caption).'  --success<br>';
				}
		}else{
			$sql_query = "INSERT INTO search (id, search_id, usernameORtitle, nameORcaption, type) VALUES('', '$content_id', '$title', '$caption', 'post_photos');";
			$result = mysqli_query($conn, $sql_query);
				if($result == true){
					echo ($title).' //-----// '.($caption).'  --success<br>';
				}
		}

		
	}
?>