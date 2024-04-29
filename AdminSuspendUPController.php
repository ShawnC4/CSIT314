<?php
//Controller class to process log in requests 
require_once 'UserProfileEntity.php';

class AdminSuspendUPController {
    private $entity;

    public function __construct() {
        $this->entity = new UserProfileEntity();
    }

    public function suspendProfile($profileId) {
        $result = $this->entity->suspendUserProfile($profileId);
        return $result;
    }
}

/*
// Include this at the top of AdminSuspendUPController.php
$controller = new AdminSuspendUPController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'suspendProfile') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    if (isset($requestData['profileId'])) {
        $profileId = $requestData['profileId'];
        $response = $controller->suspendProfile($profileId);

        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Profile ID is missing']);
    }
}
*/
