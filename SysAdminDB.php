<?php 
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "Solarity45sql";
    $db_name = "konohadb";
    $conn = null;

    try {
        $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    } 
    catch (mysqli_sql_exception) {
        echo "Not Connected";
    }

    if ($conn) {
        echo "You are connected!";
    }
?>