<?php
class Opensll{
  static private key = "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQC+KCzUNRCwuLsh".
  "4cwYmIHbNFcPBoSlaEdktzMC7ziqmcbNxSqo+krEMRArFiF6uyTbbCFkZ7TlCy1VM9UiBMJjcTH1hA9UGZzsYD".
  "U2xeulRAjQpJtyRD4JGoQ7Ug6qDN0DK9IhgElSU6D/RFaNlbFncyXAbgxWsn9IeA0edDafNXpw36pnynTEP+C6w".
  "z9I3uEWfA4FpfLAMboMrBgypg6ztfg54plTo8gwnpGCZ7y5SkbChJ0N2zJmnl3MtqjNTdIG/zBSGq3TkJkXIIvm".
  "98uqRdngQcTd7ZWJFWgvqCKOJgrdcBErcSng/UGB36MQl48uB3ICR4zQKa70DHotgI+/AgMBAAECggEABVAMCJW".
  "+9KEEoWq0kA9auWwZ7pKJDDIApKC1rSRP2fxX4JHcokHz6s1QHVQN9WbbHcJEoJCBLlEEoDfFgaDOaYbVFX3uC".
  "7R3fOcnNXOMJN7kvCeNLEEZ1plGDn45aKjZV+hWg5cY9VLe0aLwJB6FiVVfPaQVdiqggb7Q5wPqLsJ8TdFOiC".
  "56xb9s4g0n3zX09oJvfEPA1wooPKQ5ppgwpdXEZz3Sf6Jv8ZPlK6rllfG3ZBkkwYOli5HKUdCiYYXDRS7YmyU".
  "HtSdiPtDsRpMhkV/UPmeyVOKIMXX0rQrhD89mOf8Vz3vX1y2UqnHaAhGRxXe8XjLw6elB8OghQ7ZcWQKBgQD7".
  "Bd9nL+NV9PWd/Mw9TyZ19KbhhOztz8cN0FeKLuyrS4R2w3tZ40pjv1BpzZttFcAL97ldFyGpkjmuT5+/bHr2C".
  "DyiSK3IToni9IMT9ghzEBloxAnEeLsUbZRKqe1ZfPCMOh/tVyVfgyFtb5iXBRYIsQFv3ZOC1RV8Vj7lTrQWtQ".
  "KBgQDB7VzFUTUkpm/IVn8ylGECoCtM14OYeOA3zGoLl89OJteSYPrtlWiw6z7zVkYxmdm8tKDoEYNHOf3MNKw".
  "Q7HpiyKK06A+FcQUeIQ26APTrMmA5/ZuWDhyusBsr7Gpgq1wUC0qTCrt07+ffz+7mlfsvqJManrfMV+RD".
  "F2573ZfBIwKBgBCbotxA3tmhC18YiqrDwdesCB6DnOlfBdx0HFaYJDBxHqJ87HxV/WX8EmXtpIrjFYG1Mh".
  "5mmWOOuSI/QmJ32urMQLa7+EN4bscFRmbbsFNsjUHRNpQ5KKeBWH5YH8v76C5e6h3Z1i8rjdqft4jGXV7V1".
  "zJ/hnLxhipjymWBf4jBAoGBAIvagT/vq7KtsQm6j2rLpRZ+qht1hPrNmW3EJmoL5j4HNwnilLQIPwLv9GsKuf".
  "6FZIh5f109W/5e7RB6n+hokm5xIR30CVWDx1wOHFca34ZKwyivI6hYrwiwCjhn++ORUQtHhVV7tOrFJOS8".
  "kR6L5SVeng/hjM16SSy1VkFP8mQfAoGAdzFHblDZYCIXODEhjJP867ZSDzm/PQ2RcobsD6ovMB6xqq6Qwh".
  "bTwT79xrbySAd85A7NQVFh+CFxl4E4BJpQJNX5sHCVYXHp0rXGabaA3dcmIhsjfGMmEI22N9T2mk0ICRK".
  "biJwKk1IKFylTNH6KvZhrkeVfrJDjMjfWvdE9DqA=";
  static private cipher = "aes-128-gcm";

  public static function sslencrypt($plaintext){
    if(in_array(self::$cipher, openssl_get_cipher_methods())){
      $ivlen = openssl_cipher_iv_length(self::$cipher);
      $iv = openssl_random_pseudo_bytes($ivlen);
      $ciphertext = openssl_encrypt($plaintext, self::$cipher, self::$key, $options=0, $iv, $tag);
      return  base64_encode($iv).$ciphertext;
    }
  }
  public static function ssldecrypt($encrpyterdmessage){
    if(in_array(self::$cipher, openssl_get_cipher_methods())){
      $en = base64_decode($encrpyterdmessage);
      $ivlen = openssl_cipher_iv_length(self::$cipher);
      $iv = substr($en,0,$ivlen);
      $ciphertext = base64_encode(substr($en, $ivlen));
      return openssl_decrypt($ciphertext, self::$cipher, self::$key, $options=0, $iv, $tag);
    }
  }
}
?>
