<?php
require_once 'AdminCreateUPController.php';
require_once 'AdminViewUPController.php';
require_once 'AdminUpdateUPController.php';
require_once 'AdminSuspendUPController.php';

require_once 'AdminCreateUAController.php';
require_once 'AdminViewUAController.php';

//CREATE UP//
$controllerCreateUP = new AdminCreateUPController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'createProfile') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    $profileName = $requestData['profileName'];
    $activeStatus = $requestData['activeStatus'];
    $description = $requestData['description'];
    
    $response = $controllerCreateUP->createProfile($profileName, $activeStatus, $description);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'UPExists') {
    $UPExists = $controllerCreateUP->profileExists($_GET['profileName']);
    header('Content-Type: application/json');

    echo json_encode($UPExists);
    exit();
}

//CREATE UA//
$controllerCreateUA = new AdminCreateUAController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'createAccount') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    $Username = $requestData['accountUsername'];
    $Email = $requestData['accountEmail'];
    $Password = $requestData['accountPassword'];
    $activeStatus = $requestData['activeStatus'];
    $Profile_id = $requestData['accountProfile_id'];
    
    $response = $controllerCreateUA->createAccount($Username, $Email, $Password, $activeStatus, $Profile_id);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
} else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getProfiles') {
    $profiles = $controllerCreateUA->getUserProfiles();
    header('Content-Type: application/json');

    echo json_encode($profiles);
    exit();
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'UAExists') {
    $UAExists = $controllerCreateUA->accountExists($_GET['accountUsername']);
    header('Content-Type: application/json');

    echo json_encode($UAExists);
    exit();
}

//VIEW ALL PROFILE//
$controllerViewUP = new AdminViewUPController();

// Handle POST request to authenticate user
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getProfiles') {
    $profiles = $controllerViewUP->getUserProfiles();

    header('Content-Type: application/json');
    echo json_encode($profiles);
    exit();
}

//VIEW ALL ACCOUNTS//
$controllerViewUA = new AdminViewUAController();

// Handle POST request to authenticate user
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getAccounts') {
    $accounts = $controllerViewUA->getUserAccounts();

    header('Content-Type: application/json');
    echo json_encode($accounts);
    exit();

} else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getProfileById') {
    $profile = $controllerViewUA->getProfileById($_GET['profile_id']);

    header('Content-Type: application/json');
    echo json_encode($profile);
    exit();
}

//UPDATE//
$controllerUpdate = new AdminUpdateUPController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'updateProfile') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    $profileId = $requestData['profileId'];
    $profileName = $requestData['profileName'];
    $activeStatus = $requestData['activeStatus'];
    $description = $requestData['description'];
    
    $response = $controllerUpdate->updateProfile($profileId, $profileName, $activeStatus, $description);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}

//SUSPEND// 
$controllerSuspend = new AdminSuspendUPController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'suspendProfile') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    if (isset($requestData['profileId'])) {
        $profileId = $requestData['profileId'];
        $response = $controllerSuspend->suspendProfile($profileId);

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
