<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: #f4f4f4;
        }
        .login-container {
            text-align: center;
        }
        .login-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        #loginForm {
            display: inline-block;
        }
        #loginForm select,
        #loginForm input[type="text"],
        #loginForm input[type="password"],
        #loginForm button {
            margin: 5px;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        #loginForm button {
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
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
        <div class="login-title">REAL ESTATE SYSTEM</div>
        <h2>Log In</h2>
        <form id="loginForm">
            <select id="profile" name="profile">
                <option value="buyer">Buyer</option>
                <option value="seller">Seller</option>
                <option value="agent">Agent</option>
                <option value="admin">Admin</option>
            </select>
            <br>
            <input type="text" id="username" placeholder="Username" required>
            <input type="password" id="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p id="loginMessage"></p>
    </div>
    <script src="LoginApi.js"></script>
</body>
</html>