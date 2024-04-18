<?php
require 'UserProfileEntity.php';

class AdminUpdateUPController {
    private $entity;

    public function __construct () {
        $this->entity = new UserProfileEntity();
    }

    public function updateProfile ($profileId, $profileName, $createPermission, $readPermission, $updatePermission, $deletePermission) {
        $result = $this->entity->updateUserProfile($profileId, $profileName, $createPermission, $readPermission, $updatePermission, $deletePermission);
        return $result;
    }
}

$controller = new AdminUpdateUPController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'updateProfile') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    $profileId = $requestData['profileId'];
    $profileName = $requestData['profileName'];
    $createPermission = $requestData['createPermission'];
    $readPermission = $requestData['readPermission'];
    $updatePermission = $requestData['updatePermission'];
    $deletePermission = $requestData['deletePermission'];

    $response = $controller->updateProfile($profileId, $profileName, $createPermission, $readPermission, $updatePermission, $deletePermission);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
