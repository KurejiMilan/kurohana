<?php
/*RUN THIS TO UPDATE THE TABLE WITH NEW INTEREST DATA STRUCTURE*/
require('./includefiles/header.inc.php');

$sql = "SELECT * FROM interest;";
$result = mysqli_query($conn, $sql);
$content = mysqli_fetch_all($result, MYSQLI_ASSOC);
foreach ($content as $content){
	$userInterest_array = array();
	if($content['art'] == 1){
		array_push($userInterest_array, 'art');
	}if($content['FilmAnimation'] == 1){
		array_push($userInterest_array,'FilmAnimation');
	}if($content['news'] == 1){
		array_push($userInterest_array,'news');
	}if($content['design'] == 1){
		array_push($userInterest_array,'design');
	}if($content['music'] == 1){
		array_push($userInterest_array,'music');
	}if($content['entertainment'] == 1){
		array_push($userInterest_array,'entertainment');
	}if($content['comedy'] == 1){
		array_push($userInterest_array,'comedy');
	}if($content['literature'] == 1){
		array_push($userInterest_array,'literature');
	}if($content['diy'] == 1){
		array_push($userInterest_array,'diy');
	}if($content['fashion'] == 1){
		array_push($userInterest_array,'fashion');
	}if($content['scienceandtech'] == 1){
		array_push($userInterest_array,'scienceandtech');
	}if($content['education'] == 1){
		array_push($userInterest_array,'education');
	}if($content['shortstories'] == 1){
		array_push($userInterest_array,'shortstories');
	}if($content['MangaAnime'] == 1){
		array_push($userInterest_array,'MangaAnime');
	}if($content['comics'] == 1){
		array_push($userInterest_array, 'comics');
	}
$username = $content['username'];
echo $username."= ";
$string = implode('//', $userInterest_array);
echo $string;
$sql = "UPDATE interest set interest = '$string' WHERE username = '$username';";
$query = mysqli_query($conn,$sql);
	if($query == true){
		echo '  ...UPDATE SUCCESS<br>';
	}
}
?>