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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <a href="AgentLanding.php" class="logo">Buyer Hub</a>
        <nav>
            <ul>
                <li><a href="#" onclick="loadContent('BuyerView.php')">View </button></li>
                <li><a href="#" onclick="loadContent('BuyerShortList.php')">Shortlist </button></li>
                <li><a href="logout.php"> Logout</a></li>
            </ul>
        </nav>
    </div>
    <div id="body">
        <!-- Content of the body goes here -->
        <h1 class="welcome-message">Welcome to the Buyer Page!</h1>
    </div>
</body>
<script src="BuyerApi.js"></script>
</html>