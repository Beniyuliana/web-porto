<?php
class Database {
    private $host = "andria-db.id.domainesia.com"; //domain
    private $database_name = "amisbud1_portofolio"; //nama database
    private $username = "amisbud1_portofolio"; //username phpmyadmin
    private $password = "Sisteminformasi@2024"; //password phpmyadmin
    private $charset = "utf8mb4";
    public $conn; //alias koneksi

    public function getConnection(){
        $this->conn = null;
        try{
            $dsn = "mysql:host=$this->host;dbname=$this->database_name;charset=$this->charset";
            $this->conn = new PDO( $dsn , $this->username, $this->password );
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $this->conn;
    }
}