<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Create Page</title>
    <link rel="stylesheet" href="style.css">
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
