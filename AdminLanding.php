<?php
require 'AdminCreateUPController.php';
require 'AdminViewUPController.php';
require 'AdminSuspendUPController.php';

//CREATE//
$controllerCreate = new AdminCreateUPController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'createProfile') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    $profileName = $requestData['profileName'];
    $activeStatus = $requestData['activeStatus'];
    $description = $requestData['description'];
    
    $response = $controllerCreate->createProfile($profileName, $activeStatus, $description);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}


//VIEW ALL PROFILE//
$controllerView = new AdminViewUPController();

// Handle POST request to authenticate user
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getProfiles') {
    $profiles = $controllerView->getUserProfiles();

    header('Content-Type: application/json');
    echo json_encode($profiles);
    exit();
}

//Suspend Profile 
$controller = new AdminSuspendUPController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'suspendProfile') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    if (isset($requestData['profileId'])) {
        $profileId = $requestData['profileId'];
        $response = $controller->suspendProfile($profileId);

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Profile ID is missing']);
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .button-container button {
            width: 50%; /* Set button width */
            padding: 10px;
            margin: 5px;
            font-size: 16px;
        }

        .button-container {
            border: 2px solid black;
            display: flex;
            justify-content: center;
        }

        #flex {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 90%;
            width: 90%;
            padding: 5px;
        }
        
        #UPUA {
            border: 1px solid black;
            width: 90%;
            height: 80%;
        }
    </style>
</head>
<body>
    
    <div id="flex">
        <div>
            <h1>Welcome</h1>
        </div>
        <div class="button-container">
            <button onclick="loadContent('AdminUP.php')">User Profile</button>
            <button onclick="loadContent('AdminUA.php')">User Account</button>
        </div>
        <br>
        <div id="UPUA">
            
        </div>
        <br>
        <div>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
<script src="AdminApi.js"></script>
</html>
