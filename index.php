<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
<?php
    session_start();

    // Check if user is already logged in
    if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
        // If logged in, redirect to landing page
        header("Location: landing.php");
        exit;
    }
?> 
    <div class="login-container">
        <h2>Login</h2>
        <form id="loginForm">
            <input type="text" id="username" placeholder="Username" required>
            <input type="password" id="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p id="loginMessage"></p>
    </div>
</body>
<script src="ApiEndpoint.js"></script>
</html>