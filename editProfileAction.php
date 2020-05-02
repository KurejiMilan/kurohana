<?php
include('./includefiles/header.inc.php');

	if($_POST['action'] == 'updateInterest'){
		$interestObject = json_decode(utf8_encode($_POST['interestString']),true);
		$userInterestArray = array();
		if((bool)$interestObject["art"]) {array_push($userInterestArray, 'art');}
    
    	if((bool)$interestObject["FilmAnimation"]) {array_push($userInterestArray, 'FilmAnimation');}
    
    	if((bool)$interestObject["news"]) {array_push($userInterestArray, 'news');}
    
    	if((bool)$interestObject["design"]){array_push($userInterestArray, 'design');}
    
    	if((bool)$interestObject["music"]) {array_push($userInterestArray, 'music');}  
    
    	if((bool)$interestObject["entertainment"]) {array_push($userInterestArray, 'entertainment');}
    
    	if((bool)$interestObject["comedy"]) {array_push($userInterestArray, 'comedy');}
    
    	if((bool)$interestObject["literature"]) {array_push($userInterestArray, 'literature');}
    
    	if((bool)$interestObject["diy"]) {array_push($userInterestArray, 'diy');}
    
    	if((bool)$interestObject["fashion"]) {array_push($userInterestArray, 'fashion');}
    
    	if((bool)$interestObject["scienceandtech"]) {array_push($userInterestArray, 'scienceandtech');}
    
    	if((bool)$interestObject["education"]) {array_push($userInterestArray, 'education');}
    
    	if((bool)$interestObject["shortstories"]) {array_push($userInterestArray, 'shortstories');}
    
    	if((bool)$interestObject["MangaAnime"]) {array_push($userInterestArray, 'MangaAnime');}
    
		if((bool)$interestObject["comics"]) {array_push($userInterestArray, 'comics');}
		$userInterestString = implode('//', $userInterestArray);
		$sql = "UPDATE interest SET interest = '$userInterestString' WHERE username = '$user'";
		$result = mysqli_query($conn, $sql);
		echo true;
	}
	if($_POST['action'] == "updateBio"){
		$Bio = $_POST['bio'];
		$sql = "UPDATE users SET bio = ? WHERE username = ?";
		$stmt = mysqli_stmt_init($conn);
		if(mysqli_stmt_prepare($stmt, $sql)){
			mysqli_stmt_bind_param($stmt, "ss", $Bio, $user);
			mysqli_stmt_execute($stmt);
		}
		mysqli_stmt_close($stmt);
		echo true;
	}
	if($_POST['action'] == "updateSocialLinks"){
		$facebook = $_POST['facebook'];
		$youtube = $_POST['youtube'];
		$twitter = $_POST['twitter'];
		$instagram = $_POST['instagram'];
		$sql = "UPDATE sociallinks SET facebook = ?, youtube = ?, twitter = ?, instagram = ? WHERE username = ?";
		$stmt = mysqli_stmt_init($conn);
		if(mysqli_stmt_prepare($stmt, $sql)){
			mysqli_stmt_bind_param($stmt, "sssss", $facebook, $youtube, $twitter, $instagram, $user);
			mysqli_stmt_execute($stmt);
		}
		mysqli_stmt_close($stmt);
		echo true;
	}
	if($_POST['action'] == "updateCreator"){
		$jsonObject = json_decode(utf8_encode($_POST['creatingJsonString']),true);
		$sql = "UPDATE about SET individual =?, company = ?, companyname = ?, companyurl = ?, creating =?, address = ?, contact = ? WHERE username = ?";
		$stmt = mysqli_stmt_init($conn);
		if(mysqli_stmt_prepare($stmt, $sql)){
			mysqli_stmt_bind_param($stmt, "iissssss", $jsonObject['individual'], $jsonObject['company'], $jsonObject['companyname'], $jsonObject['companyurl'], $jsonObject['creating'], $jsonObject['address'], $jsonObject['contact'],$user);
			mysqli_stmt_execute($stmt);
		}
		mysqli_stmt_close($stmt);
		echo json_encode($jsonObject);
	}
?>