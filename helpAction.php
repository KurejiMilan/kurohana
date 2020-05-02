<?php
require('./includefiles/header.inc.php');
if($_POST['action'] == "filingComplain"){
	$url = $_POST['url'];
	$complain = $_POST['complain'];
	$additionalDetail = $_POST['additionalDetail'];
	$sql = "INSERT INTO complain (filedBy,url,complain,detail) VALUES (?,?,?,?);";
	$stmt = mysqli_stmt_init($conn);
	if(mysqli_stmt_prepare($stmt, $sql)){
		mysqli_stmt_bind_param($stmt, "ssss",$user, $url, $complain, $additionalDetail);
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_close($stmt);
			$jsonResponse = array("error" => false);
			$jsonResponse = json_encode($jsonResponse);
			echo $jsonResponse;
		}else{
			mysqli_stmt_close($stmt);
			$jsonResponse = array("error" => true);
			$jsonResponse = json_encode($jsonResponse);
			echo $jsonResponse;
		}
	}
}if($_POST["action"] == "report"){
	$report = $_POST['report'];
	$sql = "INSERT INTO report (reportedBy,report) VALUES (?,?);";
	$stmt = mysqli_stmt_init($conn);
	if(mysqli_stmt_prepare($stmt, $sql)){
		mysqli_stmt_bind_param($stmt, "ss",$user,$report);
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_close($stmt);
			$jsonResponse = array("error" => false);
			$jsonResponse = json_encode($jsonResponse);
			echo $jsonResponse;
		}else{
			mysqli_stmt_close($stmt);
			$jsonResponse = array("error" => true);
			$jsonResponse = json_encode($jsonResponse);
			echo $jsonResponse;
		}
	}
}
?>