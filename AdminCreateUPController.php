<?php
require 'UserProfileEntity.php';

class AdminCreateUPController {
    private $entity;

    public function __construct () {
        $this->entity = new UserProfileEntity();
    }

    public function createProfile ($profileName, $activeStatus, $description) {
        $result = $this->entity->createUserProfile($profileName, $activeStatus, $description);
        return $result;
    }
}

/*$controller = new AdminCreateUPController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'createProfile') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    $profileName = $requestData['profileName'];
    $activeStatus = $requestData['activeStatus'];
    $description = $requestData['description'];
    
    $response = $controller->createProfile($profileName, $activeStatus, $description);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}*/
?>