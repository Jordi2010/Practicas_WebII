<?php
class User {
    private $conn;
    //private $table = "users";

    public $id;
    public $username;
    public $email;
    public $balance;

    public function __construct(/*$db*/) {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = "INSERT INTO users (username, email, balance) VALUES (:username, :email, :balance)";
        $stmt = $this->conn->prepare($query);

        // Sanitizar
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->balance = htmlspecialchars(strip_tags($this->balance));

        // Bind
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":balance", $this->balance);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE users SET username = :username, email = :email, balance = :balance
        WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Sanitizar
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->balance = htmlspecialchars(strip_tags($this->balance));

        // Bind
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":balance", $this->balance);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Sanitizar
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    public function getById() {
        $query = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);
        
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
