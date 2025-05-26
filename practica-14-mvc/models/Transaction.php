<?php
require_once 'config/database.php';

class Transaction {
    private $conn;
    //private $table = "transactions";
    public $id;
    public $user_id;
    public $amount;
    public $type;
    public $description;

    public function __construct(/*$db*/) {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM transactions";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = "INSERT INTO transactions (user_id, amount, type, description) 
        VALUES (:user_id, :amount, :type, :description)";
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->amount = htmlspecialchars(strip_tags($this->amount));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->description = htmlspecialchars(strip_tags($this->description));

        // Bind
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":description", $this->description);
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE transactions SET user_id=:user_id, amount=:amount, type=:type, description=:description 
        WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->amount = htmlspecialchars(strip_tags($this->amount));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->description = htmlspecialchars(strip_tags($this->description));

        // Bind
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":description", $this->description);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM transactions WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Sanitizar
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function getById() {
        $query = "SELECT * FROM transactions WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);
        
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
