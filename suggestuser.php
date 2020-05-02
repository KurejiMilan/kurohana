<?php
require ('./includefiles/header.inc.php');

$username = mysqli_real_escape_string($conn,$user);

$suggestedUsers = ""; 
$userInterestArray = array(); 
$InterestArray = array();

$suggestedUser_array = array();
$suggestionFail = array();

$userInterestString = "";

$sql = "SELECT interest FROM interest WHERE username = '$username'";
$query = mysqli_query($conn,$sql);

if ($query == true){
	$content = mysqli_fetch_assoc($query);
	$userInterestString = $content['interest'];
	$userInterestArray = explode('//', $userInterestString);
}

$sql = "SELECT username,userid,bio FROM users WHERE username != '$username'";
$result = mysqli_query($conn,$sql);

if($result == true){
	$total_users = mysqli_num_rows($result);
	$userAssoc = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	for ($i = 0; $i < 3; $i++){
		$pass = false;
		$overridePass = 0;
		do{
			$randnum = rand(0, $total_users - 1);
			if(in_array($randnum, $suggestedUser_array)){
				++$overridePass;
			}else if(in_array($randnum, $suggestionFail)){
				++$overridePass;
			}else{
				$content_user = $userAssoc[$randnum];
				$name = $content_user['username'];
				$sql = "SELECT * FROM about WHERE username = '$name' AND creator = 1";
				$result = mysqli_query($conn, $sql);
				if($result == true){
					if(mysqli_num_rows($result) == 1){
						$sql = "SELECT id FROM follow WHERE following = '$name' AND followedby = '$username';";
						$query = mysqli_query($conn, $sql);
						if(mysqli_num_rows($query) != 1){
							$sql = "SELECT interest FROM interest WHERE username = '$name'";
							$query = mysqli_query($conn,$sql);
							if ($query == true){
								$content = mysqli_fetch_assoc($query);
								$InterestString = $content['interest'];
								$InterestArray = explode('//', $InterestString);
								$resultArray = array_intersect($userInterestArray, $InterestArray);
								$resultArrayNum = count($resultArray);
								if($resultArrayNum>2){
									$userid = $content_user['userid'];
									$sql = "SELECT profileimage FROM userprofileimg WHERE username = '$name' AND userid ='$userid';";
									$query = mysqli_query($conn, $sql);
									if(mysqli_num_rows($query) == 1){
										$content = mysqli_fetch_assoc( $query);
										$profileImage = '<img src="./uploadprofile/'.$content['profileimage'].'" class="suggestion-user__image">';
									}else{
										$profileImage = '<img src="./assets/default_avatar.jpg" class="suggestion-user__image">';
									}
									$suggestedUsers .='
									    <article class="field-container--suggestion">
                    					'.$profileImage.'
                    					<aside>
                        					<h5 class="suggestion-user__name">'.$name.'</h5>
                        					<h6 class="suggestion-user__bio">'.$content_user['bio'].'</h6>
                    					</aside>
                    					<button class="suggestion-user__follow button-outlined action-button" 
                    					data-userid = '.$userid.' data-name = '.$name.' data-action="follow">Follow</button>
                						</article>
									';
									array_push($suggestedUser_array, $randnum);
									$pass = true;
								}else{
									array_push($suggestionFail, $randnum);
									$pass = true;
								}
							}
						}
					}
				}else{
					array_push($suggestionFail, $randnum);
					$pass = true;
				}
			}
			if($overridePass > 3)
				$pass == true;
		}while($pass = false);
	}
}

echo $suggestedUsers;

?>
