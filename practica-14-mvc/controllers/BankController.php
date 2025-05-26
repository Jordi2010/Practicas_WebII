<?php
require_once 'config/database.php';
require_once 'models/User.php';
require_once 'models/Transaction.php';

class BankController {
    private $db;
    private $userModel;
    private $transactionModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();

        $this->userModel = new User($this->db);
        $this->transactionModel = new Transaction($this->db);
    }

    // FUNCIONES DE USUARIO
    public function listUsers() {
        return $this->userModel->getAll();
    }

    public function addUser($username, $email, $balance = 0) {
        $this->userModel->username = $username;
        $this->userModel->email = $email;
        $this->userModel->balance = $balance;
        return $this->userModel->create();
    }

    public function updateUser($id, $username, $email, $balance) {
        $this->userModel->id = $id;
        $this->userModel->username = $username;
        $this->userModel->email = $email;
        $this->userModel->balance = $balance;
        return $this->userModel->update();
    }

    public function deleteUser($id) {
        $this->userModel->id = $id;
        return $this->userModel->delete();
    }

    // FUNCIONES DE TRANSACCIÓN
    public function listTransactions() {
        return $this->transactionModel->getAll();
    }

    public function addTransaction($user_id, $amount, $type, $description = '') {
        $this->transactionModel->user_id = $user_id;
        $this->transactionModel->amount = $amount;
        $this->transactionModel->type = $type;
        $this->transactionModel->description = $description;
        return $this->transactionModel->create();
    }
    //--------------------------------------------------------------------------------
    public function updateTransaction($id, $user_id, $amount, $type, $description) {
        $this->transactionModel->id = $id;
        $this->transactionModel->user_id = $user_id;
        $this->transactionModel->amount = $amount;
        $this->transactionModel->type = $type;
        $this->transactionModel->description = $description;
        return $this->transactionModel->update();
    }

    public function deleteTransaction($id) {
        $this->transactionModel->id = $id;
        return $this->transactionModel->delete();
    }
    //--------------------------------------------------------------------------------
    public function getUser($id) {
        $this->userModel->id = $id;
        return $this->userModel->getById();
    }
}
