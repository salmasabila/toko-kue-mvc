<?php
include_once __DIR__ . '/../models/ItemModel.php';

class ItemController {
    private $model;

    public function __construct($db) {
        $this->model = new ItemModel($db);
    }

    public function index() {
        return $this->model->getAllItems();
    }

    public function create($data) {
        $this->model->insertItem($data['name'], $data['description'], $data['image']);
    }

    public function update($id, $name, $description, $image = null) {
        if ($image) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        } else {
            $item = $this->model->getItemById($id);
            $image = $item['image']; // Ambil gambar lama dari database
        }

        // Update nama, deskripsi, dan gambar
        $this->model->updateItem($id, $name, $description, $image);

        $this->redirectToDashboard(); // Setelah update, redirect ke dashboard
    }
    

    public function delete($id) {
        $this->model->deleteItem($id);
    }

    public function show($id) {
        return $this->model->getItemById($id);
    }

    private function redirectToDashboard() {
        header("Location: index.php?action=dashboard");
        exit;
    }
}
?>
