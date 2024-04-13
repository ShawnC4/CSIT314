<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
    <p>This is the landing page. You are logged in!</p>
    <a href="logout.php">Logout</a>
</body>
</html>