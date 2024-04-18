 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin UP Page</title>
</head>
<body>
<?php
    session_start();

    // Check if user is not logged in
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] === false) {
        header("Location: index.php");
        exit;
    }
?>
    <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
    <br>
    <button id="createProfile">Create User Profile</button>
    <form id="UpForm">
    
    </form>
    <br>
    <button id="updateProfile">Update User Profile</button>
    <form id="UpForm2">
    
    </form>
    <br>
    <div id="profileList">
        
    </div>
    <br>
    <a href="logout.php">Logout</a>
</body>
<script src="Admin.js"></script>
<script src="AdminApi.js"></script>
</html>