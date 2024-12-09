<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUserByUsername($username) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registerUser($username, $password) {
        $stmt = $this->conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, password_hash($password, PASSWORD_BCRYPT)]);
    }
}
?>
