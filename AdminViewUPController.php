<?php
// Controller class to process login requests
require_once 'UserProfileEntity.php';

class AdminViewUPController {
    private $entity;

    public function __construct() {
        // Initialize Entity object
        $this->entity = new UserProfileEntity();
    }

    public function getUserProfiles() {
        // Retrieve user profiles from the database
        $profiles = $this->entity->getUserProfiles();

        return $profiles;
    }
}

// Instantiate Controller object
/*$controller = new AdminViewUPController();

// Handle POST request to authenticate user
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getProfiles') {
    $profiles = $controller->getUserProfiles();

    header('Content-Type: application/json');
    echo json_encode($profiles);
    exit();
}*/
?>