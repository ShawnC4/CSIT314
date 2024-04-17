<?php
require 'UserProfileEntity.php';

class AdminCreateUPController {
    private $entity;

    public function __construct () {
        $this->entity = new UserProfileEntity();
    }

    public function createProfile ($profileName, $createPermission, $readPermission, $updatePermission, $deletePermission) {
        $result = $this->entity->createUserProfile($profileName, $createPermission, $readPermission, $updatePermission, $deletePermission);
        return $result;
    }
}

$controller = new AdminCreateUPController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'createProfile') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    $profileName = $requestData['profileName'];
    $createPermission = $requestData['createPermission'];
    $readPermission = $requestData['readPermission'];
    $updatePermission = $requestData['updatePermission'];
    $deletePermission = $requestData['deletePermission'];
    
    $response = $controller->createProfile($profileName, $createPermission, $readPermission, $updatePermission, $deletePermission);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>