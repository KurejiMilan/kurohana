<?php
include_once('phpdirectory/config/database.php');

$database = new Database();
$conn = $database.getConnection();

//new user table schema
if(mysqli_query($conn, "DROP TABLE users")){
  echo "<p style='font-size:15px; color:yellow'>====>deleted the users table.</p>";
  $query = mysqli_query($conn, "
    CREATE TABLE users(
    userid BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name varchar(245) NOT NULL,
    username varchar(245) NOT NULL,
    useremail varchar(245) NOT NULL,
    password varchar(245) NOT NULL,
    sign_up_date date NOT NULL,
    bio text NOT NULL,
    varified enum('0','1') NOT NULL,
    followers INT UNSIGNED NOT NULL,
    following INT UNSIGNED NOT NULL,
    active enum('0','1') NOT NULL
    );
  ");
  if($query){
    echo "<p style='font-size:15px; color:green'>.....................</p>";
    echo "<p style='font-size:15px; color:red'>
          ====>created table called user.
          </p>";
    echo "<table style='font-size:15px; color:yellow; border:1px solid black;'>
            <tr>
              <td>userid</td>
              <td>name</td>
              <td>username</td>
              <td>useremail</td>
              <td>password</td>
              <td>sign_up_date</td>
              <td>bio</td>
              <td>varified</td>
              <td>followers</td>
              <td>following</td>
              <td>active</td>
            </tr>
          </table>";
    echo "<p style='font-size:15px; color:green'>writing on file SQLfile/user.sql.....................</p>";
    rename('./SQLfile/database.sql', './SQLfile/user.sql');
    $file = fopen('./SQLfile/user.sql', "w");
    if($file){
      $data = 'create table user(
                userid BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                name varchar(245) NOT NULL,
                username varchar(245) NOT NULL,
                useremail varchar(245) NOT NULL,
                password varchar(245) NOT NULL,
                sign_up_date date NOT NULL,
                bio text NOT NULL,
                varified enum("0","1") NOT NULL,
                followers INT UNSIGNED NOT NULL,
                following INT UNSIGNED NOT NULL,
                active enum("0","1") NOT NULL
              );';
      fwrite($file, $data);
      fclose($file);
    }else echo "<p style='font-size:15px; color:red'>====>failed writing on file ./SQLfile.user.sql</p>";
  }else{
    echo "<p style='font-size:15px; color:red'>====>failed creating user table</p>";
  }
}else echo "<p style='font-size:15px; color:red'>====>failed deleting user table</p>";
?>
