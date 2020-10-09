<?php
class pwdhasser{
  public static function hasher($user_pwd){
    return hash('sha256', base64_encode('').$user_pwd.base64_encode(''));
  }
}
?>
