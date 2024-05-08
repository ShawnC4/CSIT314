<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Page</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['userID']; ?></h1>
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>