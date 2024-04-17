<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        button {
            width: 45%; /* Set button width */
            padding: 10px;
            margin: 5px;
            font-size: 16px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            width: 100%;
            height: 70%;
        }
    </style>
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
    <div class="button-container">
        <button><a href="AdminUP.php">User Profile</a></button>
        <button><a href="AdminUA.php">User Account</a></button>
    </div>
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>
