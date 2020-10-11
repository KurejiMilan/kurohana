<?php
/*Pwdhasser::hasher($userpassword)*/
class pwdhasser{
  public static function hasher($user_pwd){
    return password_hash($user_pwd, PASSWORD_ARGON2I);
  }
}


// for encryption schema

$key = random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES);
$nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
$ciphertext = sodium_crypto_secretbox('This is a secret!', $nonce, $key);
$encoded = base64_encode($nonce . $ciphertext);
var_dump($encoded);

// string 'v6KhzRACVfUCyJKCGQF4VNoPXYfeFY+/pyRZcixz4x/0jLJOo+RbeGBTiZudMLEO7aRvg44HRecC' (length=76)
$decoded = base64_decode($encoded);
$nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
$ciphertext = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
$plaintext = sodium_crypto_secretbox_open($ciphertext, $nonce, $key);
var_dump($plaintext);
// string 'This is a secret!' (length=17)
?>
