<?php
session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] == false) {
    header("Location: index.php");
    exit();
} elseif ($_SESSION['profile'] != "Buyer") {
    if ($_SESSION['profile'] == "Seller") {
        header("Location: SellerLanding.php");
    } elseif ($_SESSION['profile'] == "Admin") {
        header("Location: AdminLanding.php");
    } elseif ($_SESSION['profile'] == "Agent") {
        header("Location: AgentLanding.php");
    } else {
        header("Location: index.php");
    }
}

require_once 'BuyerShortListPropertyController.php';

$BuyerShortlistController = new BuyerShortlistController();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getShortlistedProperties') {
    $id = $_SESSION['id'];
    $shortlistedProperties = $BuyerShortlistController->getShortlistedProperties($id);
    header('Content-Type: application/json');
    echo json_encode($shortlistedProperties);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Shortlist</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="body">
        <!-- Content of the body goes here -->
        <h1 class="welcome-message">Welcome to your Shortlist!</h1>
        <!-- Shortlisted properties will be displayed here -->
        <div id="shortlist-properties">
            <!-- You can use JavaScript to dynamically populate this section -->
        </div>
    </div>
    <script src="BuyerApi.js"></script>
    <script>
        // You can add JavaScript code here to load shortlisted properties from the server and display them
    </script>
</body>
</html>
