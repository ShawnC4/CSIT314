<?php

function getPropertyDetails($propertyId) {
    return [
        'id' => $propertyId,
        'name' => 'Sample Property',
        'type' => 'House',
        'size' => '1000 sqft',
    ];
}




if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getPropertyDetails') {
    if(isset($_GET['propertyId'])) {
        // Logic to fetch property details from the database based on the property ID
        $propertyId = $_GET['propertyId'];
        $propertyDetails = getPropertyDetails($propertyId); // Implement this function to retrieve property details
        header('Content-Type: application/json');
        echo json_encode($propertyDetails);
        exit();
    }


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
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

    <!-- JavaScript Section -->
    <script>
        // Function to view details of the property
        function viewDetails(propertyId) {
            // Logic to view property details
            console.log('View details of Property ' + propertyId);
        }

        // Function to give rating for the property
        function giveRating(propertyId) {
            // Logic to give rating for the property
            console.log('Give rating for Property ' + propertyId);
        }

        // Function to give review for the property
        function giveReview(propertyId) {
            // Logic to give review for the property
            console.log('Give review for Property ' + propertyId);
        }
    </script>

</body>
<script src="SellerApi.js"></script>
</html>
