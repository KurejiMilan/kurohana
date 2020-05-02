<?php
require('./includefiles/header.inc.php');
$username=mysqli_real_escape_string($conn,$_GET['user']);
if($username!=$user)
{
        header("Location:index.php");
        exit();
}
        if (isset($_COOKIE['logid']))
        {
          $logid=hash('sha256', $_COOKIE['logid']);
          mysqli_query($conn,"DELETE FROM token WHERE logid="."'$logid'".";") or die("ERROR!");
        }
         session_destroy();
         setcookie('logid', '1', time()-3600);
         setcookie('logid_', '1', time()-3600);
         header("Location:index.php");
         exit();

?>