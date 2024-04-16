<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
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
    <a href="logout.php">Logout</a>
    <>
</body>
</html>