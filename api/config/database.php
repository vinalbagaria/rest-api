<?php

 // Singleton to connect db.
 class ConnectDb {
    // Hold the class instance.
    private static $instance = null;
    private $conn;

    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $name = 'SECCPL';

    // The db connection is established in the private constructor.
    private function __construct()
    {
      $this->conn = new PDO("mysql:host={$this->host};
      dbname={$this->name}", $this->user,$this->pass,
      array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }

    public static function getInstance()
    {
      if(!self::$instance)
      {
        self::$instance = new ConnectDb();
      }

      return self::$instance;
    }

    public function getConnection()
    {
      return $this->conn;
    }
 }

//class ConnectDb {
//
//    private $host = "localhost";
//    private $username = "root";
//    private $password = "";
//    private $database = "SECCPL";
//
//    public $connection;
//
//    // get the database connection
//    public function getConnection(){
//
//        $this->connection = null;
//
//        try{
//            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);
//            $this->connection->exec("set names utf8");
//        }catch(PDOException $exception){
//            echo "Error: " . $exception->getMessage();
//        }
//
//        return $this->connection;
//    }
//}

?>
