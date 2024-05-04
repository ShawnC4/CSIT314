<?php
    session_start();
    require_once 'AgentViewPropController.php';

    //VIEW//
    $agentViewPropController = new AgentViewPropController();

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getAgentProperties') {

        $properties = $agentViewPropController->getAgentProperties($_GET['agentId']);
        //$properties = $agentViewPropController->getAgentProperties('agent_1');
        header('Content-Type: application/json');

        echo json_encode($properties);
        exit();
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getProperty') {
        $property = $agentViewPropController->getProperty($_GET['propertyId']);
        header('Content-Type: application/json');

        echo json_encode($property);
        exit();
    }

    //CREATE//
    $agentCreatePropController = new AgentCreatePropController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'createProperty') {
        $requestData = json_decode(file_get_contents('php://input'), true);
        $Name = $requestData['Name'];
        $Type = $requestData['Type'];
        $Size = $requestData['Size'];
        $Rooms = $requestData['Rooms'];
        $Price = $requestData['Price'];
        $Location = $requestData['Location'];
        $Status = $requestData['Name'];
        $Agent_id = $requestData['Type'];
        $Size = $requestData['Size'];
        
        $response = $agentCreatePropController->createProperty($Name, $Type, $Size, $Rooms, $Price, $Location, $Status, $Seller_id, $Agent_id);

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    //UPDATE//
    $controllerUpdate = new AgentUpdatePropController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'updateProperty') {
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


?>

<!DOCTYPE html>
<html>
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
    <title>Agent View</title>
</head>
<body>
    <div>
    <h1>Properties</h1>
    </div>
    <br>
    <input type="text" id="searchProperty" placeholder="Search properties">
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content" id="modal-content">
            
        </div>
    </div>
    <br>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Property Name</th>
                    <th>Seller ID</th>
                    <th>Location</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="propertyList">
                
            </tbody>
        </table>
    </div>
</body>
</html>