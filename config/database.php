<?php
class Database {
    private static $instance = null;
    private $conn;
    
    private $servername = "b8b6wjxwwgatbkzi3sc7-mysql.services.clever-cloud.com";
    private $username = "uvzy20bldxipuq8x";
    private $password = "cTXQO8Rz00laC0L5lFP8";
    private $dbname = "b8b6wjxwwgatbkzi3sc7";
    
    private function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=$this->servername;dbname=$this->dbname", 
                $this->username, 
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->conn;
    }
}
?>
