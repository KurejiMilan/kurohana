<?php
/*Pwdhasser::hasher($userpassword)*/
class Pwdhasser{
  public static function hasher($user_pwd){
    return password_hash($user_pwd, PASSWORD_ARGON2I);
  }
}

?>
