<?php
session_start();

// Load konfigurasi database
require_once 'config/config.php';

// Load controller dan model
require_once 'controllers/ItemController.php';
require_once 'controllers/UserController.php';
require_once 'models/ItemModel.php';
require_once 'models/UserModel.php';

// Inisialisasi controller
$itemController = new ItemController($conn);
$userController = new UserController($conn);

// Routing sederhana
$action = $_GET['action'] ?? 'login'; // Default ke halaman login

switch ($action) {
    case 'dashboard':
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }
        $items = $itemController->index();
        include 'views/dashboard.php';
        break;

    case 'detail':
        if (isset($_GET['id'])) {
            $item = $itemController->show($_GET['id']);
            include 'views/detail_item.php';
        }
        break;

    case 'insert':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $itemController->create([
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'image' => $_FILES['image']['name']
            ]);
            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $_FILES['image']['name']);
            header("Location: index.php?action=dashboard");
            exit;
        }
        include 'views/insert_item.php';
        break;

        case 'update':
            if (isset($_GET['id'])) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $name = $_POST['name'];
                    $description = $_POST['description'];
                    $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : null; 
                    $itemController->update($_GET['id'], $name, $description, $image);
                }
                $item = $itemController->show($_GET['id']);
                include 'views/update_item.php'; 
            }
            break;
        

    case 'delete':
        if (isset($_GET['id'])) {
            $itemController->delete($_GET['id']);
            header("Location: index.php?action=dashboard");
            exit;
        }
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($userController->login($_POST['username'], $_POST['password'])) {
                header("Location: index.php?action=dashboard");
                exit;
            } else {
                $error = "Username atau Password salah!";
            }
        }
        include 'views/login.php';
        break;

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->register($_POST['username'], $_POST['password']);
            header("Location: index.php?action=login");
            exit;
        }
        include 'views/register.php';
        break;

    case 'logout':
        session_destroy();
        header("Location: index.php?action=login");
        exit;
        break;

    default:
        include 'views/login.php';
}
?>
