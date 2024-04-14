<?php
session_start();

// Controller class to process login requests
require_once 'UserEntity.php';

class UserController {
    private $entity;

    public function __construct() {
        // Initialize Entity object
        $this->entity = new UserEntity();
    }

    public function auth($username, $password) {
        // Retrieve user data from the database based on the provided username
        $user = $this->entity->getUserByUsername($username);

        // Validate user credentials
        if ($user && $password == $user['password']) {
            $_SESSION['logged'] = true;
            $_SESSION['username'] = $username;
            // Valid credentials
            return array("success" => true);
        } else {
            // Invalid credentials
            return array("success" => false);
        }
    }
}

// Instantiate Controller object
$controller = new UserController();

// Handle POST request to authenticate user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'login') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    $username = $requestData['username'];
    $password = $requestData['password'];

    // Perform login authentication
    $response = $controller->auth($username, $password);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>