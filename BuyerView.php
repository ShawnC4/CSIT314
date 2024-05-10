<?php
session_start();
if (!isset($_SESSION['logged']) || $_SESSION['logged'] == false) {
    header("Location: index.php");
} else if ($_SESSION['profile'] != "Buyer") {
    if ($_SESSION['profile'] == "Seller") {
        header("Location: SellerLanding.php");
    } else if ($_SESSION['profile'] == "Admin") {
        header("Location: AdminLanding.php");
    } else if ($_SESSION['profile'] == "Agent") {
        header("Location: AgentLanding.php");
    } else {
        header("Location: index.php");
    }
}

require_once 'BuyerViewPropertyController.php';
require_once 'BuyerSearchPropertyController.php';

$BuyerViewPropertyController = new BuyerViewPropertyController();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getNumberOfPages') {
    $pages = $BuyerViewPropertyController->getNumberOfPages();
    header('Content-Type: application/json');
    echo json_encode($pages);
    exit();

} else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getDashboard') {
    $properties = $BuyerViewPropertyController->getBuyerProperties($_GET['page']);
    header('Content-Type: application/json');
    echo json_encode($properties);
    exit();
}

$BuyerSearchPropertyController = new BuyerSearchPropertyController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'searchBuyerProperty') {
    $requestData = json_decode(file_get_contents('php://input'), true);

    if (isset($requestData['searchInput'])) {
        $name = $requestData['searchInput'];
        $status = isset($requestData['status']) ? $requestData['status'] : 'all'; // Default to 'all' if status is not provided
        $page = isset($requestData['page']) ? intval($requestData['page']) : 1; // Default to page 1 if page is not provided

        $result = $BuyerSearchPropertyController->searchBuyerProperty($status, $name, $page);
        header('Content-Type: application/json');
        echo json_encode($result);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'errorMessage' => 'Search input is missing']);
    }
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
    <title>Buyer Page</title>
</head>
<body>
    <div class="body">
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search properties...">

            <select id="filterSelect">
                <option value="all">All</option>
                <option value="available">Available</option>
                <option value="sold">Sold</option>
            </select>
        </div>
        <div class="page-selection">
            <label for="pageSelect">Select Page:</label>
            <select id="pageSelect">
                <!-- Options will be added here by JavaScript -->
            </select>
        </div>
        <!-- Property Listings -->
        <div class="property-listings">
            <!-- Property 1 -->
            <div class="property">
                <img src="images/Prop-1.jpg" alt="Property 1">
                <div class="property-details">
                    <!-- Add more details as needed -->
                    <h2>Property Name 2</h2>
                    <div class="buttons">
                        <button onclick="loadContent('SellerView.php')">View</button>
                        <button>Add To Shortlist</button>
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
                    <div class="buttons">
                        <button onclick="viewDetails(2)">View</button>
                        <button>Add To Shortlist</button>
                        <button onclick="giveRating(2)">Give Rating</button>
                        <button onclick="giveReview(2)">Give Review</button>
                    </div>
                </div>
            </div>

            <!-- Add more property listings as needed -->
        </div>
    </div>
</body>
</html>