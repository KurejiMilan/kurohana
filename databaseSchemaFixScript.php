<?php
// this script is used to fix the logical flaws or to improve some aspects of the existing database tables

$dbServername="localhost";
$dbUsername="root";
$dbPassword="";
$dbName="Kakumei_studios";
$conn=mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName) or die('couldn\'t connect to Server');

global $conn;

if(isset($_GET['u'])){
  $u = $_GET['u'];
  if($u==='user'||$u==='a')
    userTable();
  if($u==='verification'||$u==='a')
    verificationTable();
}else{
  echo "<h1 style='color:green'>Database fix script</h1>";
  echo "<p style='font-size:18px; color:purple'>
          ====>use this script to fix the database schema. all the table are reconsidered and modified.<br>
          ====>Usage: <code style='color:blue'>http://localhost:80/kurohana/databaseSchemaFixScript?u=a</code><br><br>
          'u' argument values:<br>
            u=a: all tables.<br>
            u=user: fix user table.<br>
            u=verification: fix verification table.<br>
            <br><br>
            ===================================================================================================
            <br>
            example:<br>
            <code style='color:blue'>http://localhost:80/kurohana/databaseSchemaFixScript?u=user</code>             used to fix the user tables <br>
            <code style='color:blue'>http://localhost:80/kurohana/databaseSchemaFixScript?u=verificaton</code>     used to fix the verificaton table <br>
            <code style='color:blue'>http://localhost:80/kurohana/databaseSchemaFixScript?u=a</code>              used to fix all the tables
        </p>";
}



// function that fixes the db_table
//for the user table
function userTable(){
  global $conn;
  $filepath= getcwd();
  $q = mysqli_query($conn, "DROP TABLE IF EXISTS users;");
  if($q){
    echo "<p style='font-size:18px; color:purple'>====>dropped the users table.</p>";
    $query = mysqli_query($conn, "
      CREATE TABLE IF NOT EXISTS users(
      userid BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
      name varchar(50) NOT NULL,
      username varchar(50) NOT NULL,
      useremail varchar(100) NOT NULL,
      password varchar(255) NOT NULL,
      sign_up_date DATE NOT NULL,
      bio text NOT NULL,
      followers INT UNSIGNED NOT NULL,
      following INT UNSIGNED NOT NULL,
      active TINYINT NOT NULL DEFAULT 0
      );
    ");
    if($query){
      echo "<p style='font-size:18px; color:green'>.....................</p>";
      echo "<p style='font-size:18px; color:red'>
            ====>created table called user.
            </p>";
      echo "<table style='font-size:18px; color:purple; border:1px solid black;'>
              <tr>
                <td>userid</td>
                <td>name</td>
                <td>username</td>
                <td>useremail</td>
                <td>password</td>
                <td>sign_up_date</td>
                <td>bio</td>
                <td>followers</td>
                <td>following</td>
                <td>active</td>
              </tr>
            </table>";
    }else{
      echo "<p style='font-size:15px; color:red'>====>failed creating users table</p>";
    }
  }else echo "<p style='font-size:15px; color:red'>====>failed droping users table</p>";
}


//for verificationTable
function verificationTable(){
  global $conn;
  $filepath= getcwd();
  if(mysqli_query($conn, "DROP TABLE IF EXISTS verification;")){
    echo "<p style='font-size:18px; color:purple'>====>dropped the verification table.</p>";
    $query = mysqli_query($conn, "
      CREATE TABLE verification(
      userid BIGINT UNSIGNED NOT NULL,
      verification_code MEDIUMINT UNSIGNED NOT NULL,
      time DATETIME NOT NULL,
      verified TINYINT NOT NULL DEFAULT 0,
      FOREIGN KEY (userid) REFERENCES users(userid)
      );
    ");
    if($query){
      echo "<p style='font-size:18px; color:green'>.....................</p>";
      echo "<p style='font-size:18px; color:red'>
            ====>created table called verification.
            </p>";
      echo "<table style='font-size:18px; color:purple; border:1px solid black;'>
              <tr style='color:purple; border:1px solid black;'>
                <td style='color:purple; border:1px solid black;'>userid</td>
                <td style='color:purple; border:1px solid black;'>verification_code</td>
                <td style='color:purple; border:1px solid black;'>time</td>
                <td style='color:purple; border:1px solid black;'>verified</td>
              </tr>
            </table>";
    }else{
      echo "<p style='font-size:15px; color:red'>====>failed creating user verification</p>";
    }
  }else echo "<p style='font-size:15px; color:red'>====>failed droping verificaton table</p>";
}
?>
