<?php

session_start();
require_once 'UserController.php';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userController = new UserController();
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($userController->login($username, $password)) {
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;

        header("Location: landing.php");
        exit;
    } else {
        header("Location: index.php");
        exit;
    }
} else {
   header("Location: index.php");
   exit;
}
?>
