<?php
require_once 'AdminCreateUPController.php';
require_once 'AdminViewUPController.php';
require_once 'AdminUpdateUPController.php';
require_once 'AdminSuspendUPController.php';

//CREATE//
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'createProfile') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    $profileName = $requestData['profileName'];
    $activeStatus = $requestData['activeStatus'];
    $description = $requestData['description'];
	
    $controllerCreate = new AdminCreateUPController();
    $response = $controllerCreate->createProfile($profileName, $activeStatus, $description);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}


//VIEW ALL PROFILE//
// Handle POST request to authenticate user
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getProfiles') {
	$controllerView = new AdminViewUPController();
	$profiles = $controllerView->getUserProfiles();

    header('Content-Type: application/json');
    echo json_encode($profiles);
    exit();
}

//UPDATE//
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'updateProfile') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    $profileId = $requestData['profileId'];
    $profileName = $requestData['profileName'];
    $activeStatus = $requestData['activeStatus'];
    $description = $requestData['description'];
    
	$controllerUpdate = new AdminUpdateUPController();
    $response = $controllerUpdate->updateProfile($profileId, $profileName, $activeStatus, $description);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}

//SUSPEND// 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'suspendProfile') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    if (isset($requestData['profileId'])) {
        $profileId = $requestData['profileId'];
		
		$controllerSuspend = new AdminSuspendUPController();
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
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin UP Page</title>
</head>
<body>
    <br>
    <button id="createProfile">Create User Profile</button>
    <br>
    <input type="text" id="searchInput" placeholder="Search profiles">
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content" id="modal-content">
            
        </div>
    </div>
    <br>
    <div id="profileList">
      
    </div> 
    <br>
</body>
</html>