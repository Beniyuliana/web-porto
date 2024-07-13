<?php
class Users{
    // Connection
    private $conn;
    // Table
    private $db_table = "users";
    // Columns
    public $id;
    public $full_name;
    public $email;
    public $password;
    public $photo;
    public $job;
    public $expected_position;
    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }
    // GET ALL
    public function getUsers(){
        $sqlQuery = "SELECT id, full_name, email, password, photo, job, expected_position FROM ". $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery); //untuk mengkoneksikan dan eksekusi query
        $stmt->execute();
        return $stmt;
    }

    // GET ALL
    public function getTotalStudent(){
        $sqlQuery = "SELECT count(id) as total_student FROM ". $this->db_table . " WHERE job = 'Student'";
        $stmt = $this->conn->prepare($sqlQuery); //untuk mengkoneksikan dan eksekusi query
        $stmt->execute();
        return $stmt;
    }
    // CREATE
    public function createUser(){
        $sqlQuery = "INSERT INTO ". $this->db_table ."
        SET
        full_name = :full_name,
        email = :email,
        password = :password,
        photo = :photo,
        job = :job,
        expected_position = :expected_position";
        $stmt = $this->conn->prepare($sqlQuery);
            // sanitize untuk menghindari data eksekusi / inject apps
            $this->full_name=htmlspecialchars(strip_tags($this->full_name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->password=htmlspecialchars(strip_tags($this->password));
            $this->photo=htmlspecialchars(strip_tags($this->photo));
            $this->job=htmlspecialchars(strip_tags($this->job));
            $this->expected_position=htmlspecialchars(strip_tags($this->expected_position));
            // bind data untuk mapping data
            $stmt->bindParam(":full_name", $this->full_name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":photo", $this->photo);
            $stmt->bindParam(":job", $this->job);
            $stmt->bindParam(":expected_position", $this->expected_position);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
    // READ single
    public function getSingleUser(){
        $sqlQuery = "SELECT
        id,
        full_name,
        email,
        password,
        photo,
        job,
        expected_position        
        FROM
        ". $this->db_table ."
        WHERE
        id = ?
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->full_name = $dataRow['full_name'];
        $this->email = $dataRow['email'];
        $this->password = $dataRow['password'];
        $this->photo = $dataRow['photo'];
        $this->job = $dataRow['job'];
        $this->expected_position = $dataRow['expected_position'];
    }
    // UPDATE
    public function updateUser(){
        $sqlQuery = "UPDATE
        ". $this->db_table ."
        SET
        full_name = :full_name,
        email = :email,
        password = :password,
        photo = :photo,
        job = :job,
        expected_position = :expected_position
        WHERE
        id = :id";
        $stmt = $this->conn->prepare($sqlQuery);
        
        $this->full_name=htmlspecialchars(strip_tags($this->full_name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->photo=htmlspecialchars(strip_tags($this->photo));
        $this->job=htmlspecialchars(strip_tags($this->job));
        $this->expected_position=htmlspecialchars(strip_tags($this->expected_position));
        $this->id=htmlspecialchars(strip_tags($this->id));
        // bind data
        $stmt->bindParam(":full_name", $this->full_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":photo", $this->photo);
        $stmt->bindParam(":job", $this->job);
        $stmt->bindParam(":expected_position", $this->expected_position);
        $stmt->bindParam(":id", $this->id);
        $stmt->fetchAll();

        try {
            $stmt->execute();
        }
        catch(PDOException $exception) {
            die($exception->getMessage());
        }
        
        if (count($stmt->fetchAll()) == 0) {
            return true;
        }
    }
    // DELETE
    function deleteUser(){
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function prosesLogin(){
        $sqlQuery = "SELECT
        id,
        full_name,
        email,
        password,
        photo,
        job,
        expected_position         
        FROM
        ". $this->db_table ."
        WHERE
        email = :email AND
        password = :password
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(!empty($dataRow)){
            return $dataRow;
        }else{
            return false;
        }
    }

    public function prosesLogout(){    
        session_start();
        session_unset();
        session_destroy();
        return true;
    }
}
?>