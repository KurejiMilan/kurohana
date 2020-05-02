<?php
include("includefiles/header.inc.php");
	if($_POST['action'] == "generalSettings"){
		$settingsJson = json_decode(utf8_encode($_POST['jsonData']), true);
		if($settingsJson['creator'] == "false"){
			if(filter_var($settingsJson['email'], FILTER_VALIDATE_EMAIL)){
				$sql = "UPDATE users SET name = ?, useremail =? WHERE username =?";
				$stmt = mysqli_stmt_init($conn);
				if(mysqli_stmt_prepare($stmt, $sql)){
					mysqli_stmt_bind_param($stmt, "sss", $settingsJson['name'], $settingsJson['email'], $user);
					if(mysqli_stmt_execute($stmt)){
						mysqli_stmt_close($stmt);
						$jsonSuccess = array(
							"error" => false
						);
						$jsonSuccess = json_encode($jsonSuccess);
						echo $jsonSuccess;
					}else{
						$jsonError = array(
							"error" => true,
							"cause" => "some kind of error has occured."
						);
						$jsonError = json_encode($jsonError);
						echo $jsonError;
					}
				}				
			}else{
				$jsonError = array(
					"error" => true,
					"cause" => "invalid email format"
				);
				$jsonError = json_encode($jsonError);
				echo $jsonError;
			}
		}else{
			if(validate()){
				$sql = "UPDATE users SET name = ?, useremail =? WHERE username =?";
				$stmt = mysqli_stmt_init($conn);
				if(mysqli_stmt_prepare($stmt, $sql)){
					mysqli_stmt_bind_param($stmt, "sss", $settingsJson['name'], $settingsJson['email'], $user);
					if(mysqli_stmt_execute($stmt)){
						mysqli_stmt_close($stmt);
						$sql = "UPDATE about SET address = ?, contact =? WHERE username = ?";
						$stmt = mysqli_stmt_init($conn);
						if(mysqli_stmt_prepare($stmt, $sql)){
							mysqli_stmt_bind_param($stmt, "sss", $settingsJson['address'], $settingsJson['contact'], $user);
							if(mysqli_stmt_execute($stmt)){
								$jsonSuccess = array(
									"error" => false
								);
								$jsonSuccess = json_encode($jsonSuccess);
								echo $jsonSuccess;
							}else{
								$jsonError = array(
								"error" => true,
								"cause" => "some kind of error has occured"
								);
								$jsonError = json_encode($jsonError);
								echo $jsonError;
							}
						}
					}else{
						$jsonError = array(
							"error" => true,
							"cause" => "some kind of error has occured"
						);
						$jsonError = json_encode($jsonError);
						echo $jsonError;
					}
				}
			}else{
				$jsonError = array(
					"error" => true,
					"cause" => "invalid email format"
				);
				$jsonError = json_encode($jsonError);
				echo $jsonError;
			}
		}

		function validate(){
			return ((filter_var($settingsJson['email'], FILTER_VALIDATE_EMAIL))&&(preg_match('/[0-9]/', $settingsJson['contact']))&&preg_match("/^98/", $settingsJson['contact'])&&(strlen($settingsJson['contact']) == 10));
		}
	}
	if($_POST['action'] == "resetPassword"){
		$sql = "SELECT userpassword FROM users WHERE username = ?";
		$stmt = mysqli_stmt_init($conn);
		if(mysqli_stmt_prepare($stmt, $sql)){
			mysqli_bind_param($stmt, "s", $user);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			mysqli_stmt_close($stmt);
			if(mysqli_num_rows($result) == 1){
				$hashedPassword = hash('sha256', Salt::get_presalt().$_POST['oldPassword'].Salt::get_postsalt());
				$content = mysqli_fetch_assoc($result);
				if($content['userpassword'] == $hashedPassword){
					if($_POST['newPassword'] == $_POST['confirmPassword']){
						$newHashedPassword = hash('sha256', Salt::get_presalt().$_POST['newPassword'].Salt::get_postsalt());
						$sql = "UPDATE users SET userpassword = ? WHERE username = ?";
						$stmt = mysqli_stmt_init($conn);
						if(mysqli_stmt_prepare($stmt, $sql)){
							mysqli_stmt_bind_param($stmt, "ss", $newHashedPassword, $user);
							if(mysqli_stmt_execute($stmt)){
								$jsonSuccess = array(
									"error" => false
								);
								$jsonSuccess = json_encode($jsonSuccess);
								echo $jsonSuccess;
							}else{
								$jsonError = array(
									"error" => true,
									"cause" => ""
								);
								$jsonError = json_encode($jsonError);
								echo $jsonError;
							}
						}
					}else{
						$jsonError = array(
							"error" => true,
							"cause" => "new password and confirm password doesn't match."
						);
						$jsonError = json_encode($jsonError);
						echo $jsonError;
					}
				}else{
					$jsonError = array(
						"error" => true,
						"cause" => "old password doesn't match with the existing one."
					);
					$jsonError = json_encode($jsonError);
					echo $jsonError;
				}
			}
		}
	}
	if($_POST['action'] == "likesSettings"){
		if($_POST['likes']){
			$likes = 1;
		}else{
			$likes = 0;
		}
		$sql = "UPDATE settings SET likes = ? WHERE username = ?;";
		$stmt =  mysqli_stmt_init($conn);
		if(mysqli_stmt_prepare($stmt, $sql)){
			mysqli_stmt_bind_param($stmt, "is", $likes, $user);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
		echo $_POST['likes'];
	}
	if($_POST['action'] == "commentsSettings"){
		if($_POST['comments']){
			$comments = 1;
		}else{
			$comments = 0;
		}
		$sql = "UPDATE settings SET comments = ? WHERE username = ?;";
		$stmt =  mysqli_stmt_init($conn);
		if(mysqli_stmt_prepare($stmt, $sql)){
			mysqli_stmt_bind_param($stmt, "is", $comments, $user);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
		echo $_POST['comments'];
	}
?>