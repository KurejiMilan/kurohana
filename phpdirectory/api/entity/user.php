<?php
class user{
  private $conn;

  public function __construct($database){
    $this->conn = $database;
  }

  public function validateCredentials($email,$name, $username, $pwd, $pwd1){
    if(empty($email)||empty($name)||empty($username)||empty($pwd)||empty($pwd1)){
      return false;
    }else if((!filter_var($email,FILTER_VALIDATE_EMAIL))||(!preg_match("/^[a-zA-Z0-9_~\-]*$/",$username))){
      return false;
    }else if((strlen(pwd)<8)||(strlen(pwd)>21)||(strlen(username)>15)||(strlen(name)>15)){
      return false;
    }elseif (strcmp($pwd, $pwd1)!=0) {
      return false;
    }else return true;
  }

  public function check_existing_email($email){
    try {
      $query = "SELECT * FROM users WHERE useremail=:email";
      $statement = $conn->prepare($query);
      $statement->execute(['email'=>$email]]);
      return $statement->rowCount();
    } catch (Exception $e) {
      return "error";
    }
  }

  public function check_existing_username($uname){
    try {
      $query = "SELECT * FROM users WHERE username=:uname";
      $statement = $conn->prepare($query);
      $statement->execute(['uname'=>$uname]);
      return $statement->rowCount();
    } catch (Exception $e) {
      return "error";
    }
  }
}
?>
