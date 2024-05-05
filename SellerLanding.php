<?php
session_start();

require_once 'SellerViewPropertyController.php';
require_once 'SellerCreateRatingController.php';

//VIEW//
$SellerViewPropertyController = new SellerViewPropertyController();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getDashboard') {
    if(isset($_GET['sellerId'])) {
        
        $properties = $SellerViewPropertyController->getSellerProperties($_GET['sellerId']);
        header('Content-Type: application/json');
        echo json_encode($properties);
        exit();
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'viewProperty') {
    if(isset($_GET['propertyId'])) {
        $propertyDetails = $SellerViewPropertyController->getPropertyByID($_GET['propertyId']);
        
        header('Content-Type: application/json');
        echo json_encode($propertyDetails);
        exit();
    }
}

//CREATE RATING//
$SellerCreateRatingController = new SellerCreateRatingController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'createRating') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    $rating = $requestData['name'];
    $customer_id = $requestData['customer_id'];
    $agent_id = $requestData['agent_id'];
    
    $response = $agentCreatePropController->createRating($rating, $customer_id, $Agent_id);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
/* The Modal (background) */
.propertyModal {
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
  width: 60%;
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

#details {
    display: flex;
    align-items: center;
    justify-content: space-around;
    margin-bottom: 10px;
}
</style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Hub</title>
    <link rel="stylesheet" href="style.css"> <!-- Include your CSS file -->
</head>
<body>

    <!-- Header Section -->
    <div class="header">
        <div class="logo">Seller Hub</div>
    </div>

    <!-- Body Section -->
    <div class="body">
        <h1>Welcome to Seller Hub</h1>

        <!-- Property Listings -->
        <div class="property-listings">
            <!-- Property 1 -->
            <div class="property">
                <img src="images/Prop-1.jpg" alt="Property 1">
                <div class="property-details">
                    <!-- Add more details as needed -->
                    <div class="status">Available</div>
                    <div class="buttons">
                        <button onclick="loadContent('SellerView.php')">View</button>
                        <button onclick="giveRating(1)" class="hidden">Give Rating</button>
                        <button onclick="giveReview(1)" class="hidden">Give Review</button>
                    </div>
                </div>
            </div>

            <!-- Property 2 -->
            <div class="property">
            <img src="images/Prop-2.jpg" alt="Property 2">
                <div class="property-details">
                    <h2>Property Name 2</h2>
                    <div class="status">Sold</div>
                    <div class="buttons">
                        <button onclick="viewDetails(2)">View</button>
                        <button onclick="giveRating(2)">Give Rating</button>
                        <button onclick="giveReview(2)">Give Review</button>
                    </div>
                </div>
            </div>

            <!-- Add more property listings as needed -->
        </div>
    </div>
    <div id="myModal" class="propertyModal">
        <!-- Modal content -->
        <div class="modal-content" id="modal-content">
            
        </div>
    </div>
</body>
<script>
    if (<?php echo isset($_SESSION['userID']) ? 'true' : 'false'; ?>) {
        window.userID = "<?php echo $_SESSION['userID']; ?>";
    }
</script>
<script src="SellerApi.js"></script>
</html>
