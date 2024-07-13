<?php
class Skills
{
    // Connection
    private $conn;
    // Table
    private $db_table = "skills";
    // Columns
    public $id;
    public $user_id;
    public $skill_name;
    public $rating;
    public $description;
    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // GET ALL
    public function getSkills()
    {
        $sqlQuery = "SELECT id, user_id, skill_name, rating, description FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery); //untuk mengkoneksikan dan eksekusi query
        $stmt->execute();
        return $stmt;
    }

    // GET ALL
    public function getTotalSkills()
    {
        $sqlQuery = "SELECT count(id) as total_skills FROM " . $this->db_table . " WHERE skill_name = ''";
        $stmt = $this->conn->prepare($sqlQuery); //untuk mengkoneksikan dan eksekusi query
        $stmt->execute();
        return $stmt;
    }
    // CREATE
    public function createSkills()
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . "
        SET
        user_id = :user_id,
        skill_name = :skill_name,
        rating = :rating,
        description = :description";
        $stmt = $this->conn->prepare($sqlQuery);
        // sanitize untuk menghindari data eksekusi / inject apps
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->skill_name = htmlspecialchars(strip_tags($this->skill_name));
        $this->rating = htmlspecialchars(strip_tags($this->rating));
        $this->description = htmlspecialchars(strip_tags($this->description));
        // bind data untuk mapping data
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":skill_name", $this->skill_name);
        $stmt->bindParam(":rating", $this->rating);
        $stmt->bindParam(":description", $this->description);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // READ single
    public function getSingleSkills()
    {
        $sqlQuery = "SELECT
        id,
        user_id,
        skill_name,
        rating,
        description
        FROM
        " . $this->db_table . "
        WHERE
        id = ?
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->user_id = $dataRow['user_id'];
        $this->skill_name = $dataRow['skill_name'];
        $this->rating = $dataRow['rating'];
        $this->description = $dataRow['description'];
    }
    // UPDATE
    public function updateSkills()
    {
        $sqlQuery = "UPDATE
        " . $this->db_table . "
        SET
        user_id = :user_id,
        skill_name = :skill_name,
        rating = :rating,
        description = :description
        WHERE
        id = :id";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->skill_name = htmlspecialchars(strip_tags($this->skill_name));
        $this->rating = htmlspecialchars(strip_tags($this->rating));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->id = htmlspecialchars(strip_tags($this->id));
        // bind data
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":skill_name", $this->skill_name);
        $stmt->bindParam(":rating", $this->rating);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":id", $this->id);
        $stmt->fetchAll();

        try {
            $stmt->execute();
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }

        if (count($stmt->fetchAll()) == 0) {
            return true;
        }
    }
    // DELETE
    function deleteSkills()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function prosesLogin()
    {
        $sqlQuery = "SELECT
        id,
        user_id,
        skill_name,
        rating,
        description
        FROM
        " . $this->db_table . "
        WHERE
        user_id = :user_id
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($dataRow)) {
            return $dataRow;
        } else {
            return false;
        }
    }

    public function prosesLogout()
    {
        session_start();
        session_unset();
        session_destroy();
        return true;
    }
}