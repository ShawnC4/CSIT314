<?php
session_start(); // Start the session

// Check if the agent's user ID is set in the session
if(isset($_SESSION['userID'])) {
    $agentUserID = $_SESSION['userID'];
    // Now you can use $agentUserID wherever you need the agent's user ID in this page
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Create Page</title>
    <link rel="stylesheet" href="style.css">

    <script>
        createNewProperty = (event) => {
            event.preventDefault();
            const propertyName = document.getElementById('name').value;
            const propertyType = document.getElementById('type').value;
            const propertySize = document.getElementById('sqfeet').value;
            const propertyRooms = document.getElementById('rooms').value;
            const propertyPrice = document.getElementById('price').value;
            const propertyLocation = document.getElementById('location').value;
            const propertyStatus = "available";
            const propertyImage = document.getElementById('image').files[0];
            const propertyViews = 0;
            const propertySeller = document.getElementById('seller').value;
            const propertyAgent = "<?php echo $agentUserID; ?>";

            const formData = new FormData();
            formData.append('propertyName', propertyName);
            formData.append('propertyType', propertyType);
            formData.append('propertySize', propertySize);
            formData.append('propertyRooms', propertyRooms);
            formData.append('propertyPrice', propertyPrice);
            formData.append('propertyLocation', propertyLocation);
            formData.append('propertyStatus', propertyStatus);
            formData.append('propertyImage', propertyImage);
            formData.append('propertyViews', propertyViews);
            formData.append('propertySeller', propertySeller);
            formData.append('propertyAgent', propertyAgent);

            fetch('AgentView.php?action=createProperty', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                //this.fetchUserAccounts();
                alert(`Property ${propertyName} was created successfully!`);
            });
        }

    </script>

</head>
<body>
    <div class="body">
        <h2>Create Property Listing</h2>
        <form action="submit_listing.php" method="POST" enctype="multipart/form-data">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br>

            <label for="type">Type:</label><br>
            <input type="text" id="type" name="type" required><br>

            <label for="sqfeet">Square Feet:</label><br>
            <input type="number" id="sqfeet" name="sqfeet" required><br>

            <label for="rooms">Rooms:</label><br>
            <input type="number" id="rooms" name="rooms" required><br>

            <label for="price">Price:</label><br>
            <input type="number" id="price" name="price" required><br>

            <label for="location">Location:</label><br>
            <input type="text" id="location" name="location" required><br>

            <label for="seller">Seller:</label><br>
            <input type="text" id="seller" name="seller" required><br>

            <label for="image">Upload Image:</label><br>
            <input type="file" id="image" name="image" accept="image/*"><br>

            <input type="submit" value="Create">
        </form>
    </div>
</body>
</html>