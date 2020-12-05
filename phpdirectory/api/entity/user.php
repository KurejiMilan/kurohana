<?php
include_once '../../pwd_hash_dir/pwdhash.php';
include_once '../../encryptor/opensslencryption.php';
class User{
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
      $statement->execute(array('email' => email));
      return $statement->rowCount();
    } catch (Exception $e) {
      return 503;
    }
  }

  public function check_existing_username($uname){
    try {
      $query = "SELECT * FROM users WHERE username=:uname";
      $statement = $conn->prepare($query);
      $statement->execute(array(':uname' => uname));
      return $statement->rowCount();
    } catch (Exception $e) {
      return 503;
    }
  }

  public function createuser($n, $un, $ue, $ps){
    try {
      Opensll::sslencrypt($ue);
      Pwdhasser::hasher($ps);
      $bio = "Hi, Im".$n ".";
      $d = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
      $q = "INSERT INTO users(name, username, useremail, password, sign_up_date, bio) VALUES(:nm,:uname,:umail,:pwd,:sdt,:bio)";
      $statement = $conn->prepare($q);
      $statement->bindParam([':nm'=>$n, ':uname'=>$un, ':umail'=> Opensll::sslencrypt($ue),]);
      $statement->execute();
    } catch (Exception $e) {

    }

  }
}
?>
