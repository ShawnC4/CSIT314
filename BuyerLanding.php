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
require_once 'BuyerShortlistPropertyController.php';

//VIEw
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
} else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'shortListExists') {
    $exists = $BuyerViewPropertyController->shortListExists($_GET['propertyId'], $_GET['buyerId']);
    header('Content-Type: application/json');
    echo json_encode($exists);
    exit();
}

//ADD SHORTLIST
$BuyerShortlistPropertyController = new BuyerShortlistPropertyController();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'shortListProperty') {
    $result = $BuyerShortlistPropertyController->shortListProperty($_GET['propertyId'], $_GET['buyerId']);
    header('Content-Type: application/json');
    echo json_encode($result);
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <a href="AgentLanding.php" class="logo">Buyer Hub</a>
        <nav>
            <ul>
                <li><a href="#" onclick="loadContent('BuyerView.php')">View </button></li>
                <li><a href="logout.php"> Logout</a></li>
            </ul>
        </nav>
    </div>
    <div id="body">
        <!-- Content of the body goes here -->
        <h1 class="welcome-message">Welcome to the Buyer Page!</h1>
    </div>
</body>
<script>
    if (<?php echo isset($_SESSION['userID']) ? 'true' : 'false'; ?>) {
        window.userID = "<?php echo $_SESSION['userID']; ?>";
    }
</script>
<script src="BuyerApi.js"></script>
</html>