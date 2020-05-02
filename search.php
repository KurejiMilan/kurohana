<?php
	include('./includefiles/header.inc.php');
	$searchOutput = '';
	if(isset($_POST['search'])){
		$search = metaphone($_POST['search']);
		$sql = "SELECT search_id, type FROM search WHERE usernameORtitle = ? or nameORcaption = ? ";
		$stmt = mysqli_stmt_init($conn);
		if(mysqli_stmt_prepare($stmt, $sql)){
			mysqli_stmt_bind_param($stmt, "ss", $search, $search);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			if(mysqli_num_rows($result) > 0){
				$contents = mysqli_fetch_all($result, MYSQLI_ASSOC);
				foreach ($contents as $content) {
					if($content['type'] == 'profile'){
						$sql = "SELECT username,bio FROM users WHERE userid = ?;";
						$stmt = mysqli_stmt_init($conn);
						if(mysqli_stmt_prepare($stmt, $sql)){
							mysqli_stmt_bind_param($stmt,"i",$content['search_id']);
							mysqli_stmt_execute($stmt);
							$result = mysqli_stmt_get_result($stmt);
							if(mysqli_num_rows($result) > 0){
								$profile_info = mysqli_fetch_assoc($result);
								$searchOutput .='
								NAME ='.$profile_info["username"].'<br>
								BIO ='.$profile_info["bio"].'<br><hr>'; 
							}
						}
					}else{
						$sql = "SELECT username, title, caption FROM posts WHERE id = ?;";
						$stmt = mysqli_stmt_init($conn);
						if(mysqli_stmt_prepare($stmt, $sql)){
							mysqli_stmt_bind_param($stmt,"i",$content['search_id']);
							mysqli_stmt_execute($stmt);
							$result = mysqli_stmt_get_result($stmt);
							if(mysqli_num_rows($result) > 0){
								$post_info = mysqli_fetch_assoc($result);
								$searchOutput .='
								NAME ='.$post_info["username"].'<br>
								TITLE ='.$post_info["title"].'<br>
								CAPTION ='.$post_info["caption"].'<br><hr>'; 
							}
						}
					}
				}echo $searchOutput;
			}else{
				echo 'No results!';
			}
		}else{
			echo 'opps something went wrong!';
		}

	}
?>
