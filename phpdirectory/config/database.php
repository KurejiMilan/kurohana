<?php

class Database{
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "Kakumei_studios";
    private $username = "root";
    private $password = "";
    public $conn;
  
    // get the database connection
    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
class Salt{
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
