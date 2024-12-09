<?php
include_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $model;

    public function __construct($db) {
        $this->model = new UserModel($db);
    }

    public function login($username, $password) {
        $user = $this->model->getUserByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
        return false;
    }

    public function register($username, $password) {
        $this->model->registerUser($username, $password);
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }
}
?>
