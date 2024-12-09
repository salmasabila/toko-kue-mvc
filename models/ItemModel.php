<?php
class ItemModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllItems() {
        $stmt = $this->conn->prepare("SELECT * FROM items");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItemById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM items WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertItem($name, $description, $image) {
        $stmt = $this->conn->prepare("INSERT INTO items (name, description, image) VALUES (?, ?, ?)");
        $stmt->execute([$name, $description, $image]);
    }

    public function updateItem($id, $name, $description, $image) {
        $stmt = $this->conn->prepare("UPDATE items SET name = ?, description = ?, image = ? WHERE id = ?");
        $stmt->execute([$name, $description, $image, $id]);
    }
    

    public function deleteItem($id) {
        $stmt = $this->conn->prepare("DELETE FROM items WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>
