<?php

$dbServername="localhost";
$dbUsername="root";
$dbPassword="";
$dbName="Kakumei_studios";

$conn=mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName) or die('couldn\'t connect to Server');//contects to the data base if succesful return a link identifier
  
      class Salt
	  {
		  static private $presalt='kakumei';
		  static private $postsalt='misa444555aarrmark9090456789';
		  
		  public static function get_presalt()
		  { 
		    return self::$presalt;
		  }
		  public static function get_postsalt()
		  {
		    return self::$postsalt;
		  }		  
	  }	 
?>