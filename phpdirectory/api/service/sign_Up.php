<?php
include_once '../../config/database.php';
include_once '../entity/user.php';

header("Access-Control-Allow-Origin: http://127.0.0.1");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$data = json_decode(file_get_contents("php://input"),true);

$email = $data['email'];
$name = $data['name'];
$username = $data['username'];
$password = $data['password'];
$cpassword = $data['confirmPassword'];

if(!$user->validateCredentials($email, $name, $username, $password, $cpassword)){
  http_response_code(400);
  $json_response = json_encode(array('responseCode' => 0, 'responseText'=> 'invalid credentials'));
  echo $json_response;
  exit();
}
$a = $user->check_existing_email($email);
if(!$a===0){
  if($a===503){
    http_response_code(503);
    $json_response = json_encode(array('responseCode'=> 503, 'responseText'=> 'not avalilable'));
    return $json_response;
    exit();
  }else{
    http_response_code(400);
    $json_response = json_encode(array('responseCode' => 1, 'responseText'=> 'email already exits'));
    return $json_response;
    exit();
  }
}
$b = $user->check_existing_username($username);
if(!$b===0){
  if($b===503){
    http_response_code(503);
    $json_response = json_encode(array('responseCode'=> 503, 'responseText'=> 'not avalilable'));
    return $json_response;
    exit();
  }else{
    http_response_code(400);
    $json_response = json_encode(array('responseCode' => 2, 'responseText'=> 'username already exits'));
    return $json_response;
    exit();
  }
}

$c = $user->();



exit();
?>
