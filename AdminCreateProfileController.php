<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'createProfile') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    $profileName = $requestData['profileName'];
    $createPermission = $requestData['createPermission'];
    $readPermission = $requestData['readPermission'];
    $updatePermission = $requestData['updatePermission'];
    $deletePermission = $requestData['deletePermission'];

    $response = ['success' => true];

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>