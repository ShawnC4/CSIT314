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

    function redirectDashboard () {
        // Check if user is already logged in
        if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
            // If logged in, redirect to landing page
            switch ($_SESSION['profile']) {
                case 'buyer':
                    header("Location: BuyerLanding.php");
                    break;
                case 'seller':
                    header("Location: SellerLanding.php");
                    break;
                case 'agent':
                    header("Location: AgentLanding.php");
                    break;
                case 'admin':
                    header("Location: AdminLanding.php");
                    break;
                default:
                    header("Location: logout.php");
                    break;
            }
            exit;
        }
    }

    redirectDashboard();
?> 
    <div class="login-container">
        <h2>Login</h2>
        <form id="loginForm">
            <select id="profile" name="profile">
                <option value="admin">Admin</option>
                <option value="buyer">Buyer</option>
                <option value="seller">Seller</option>
                <option value="agent">Agent</option>
            </select>
            <br>
            <input type="text" id="username" placeholder="Username" required>
            <input type="password" id="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p id="loginMessage"></p>
    </div>
</body>
<script src="ApiEndpoint.js"></script>
</html>