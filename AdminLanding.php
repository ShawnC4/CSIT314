

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
            justify-content: space-between;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .button-container button {
            width: 50%; /* Set button width */
            padding: 10px;
            margin: 5px;
            font-size: 16px;
        }

        .button-container {
            border: 2px solid black;
            display: flex;
            justify-content: center;
        }

        #flex {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 90%;
            width: 90%;
            padding: 5px;
        }
        
        #UPUA {
            border: 1px solid black;
            width: 90%;
            height: 80%;
        }
    </style>
</head>
<body>
    
    <div id="flex">
        <div>
            <h1>Welcome</h1>
        </div>
        <div class="button-container">
            <button onclick="loadContent('AdminUP.php')">User Profile</button>
            <button onclick="loadContent('AdminUA.php')">User Account</button>
        </div>
        <br>
        <div id="UPUA">
            
        </div>
        <br>
        <div>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
<script src="AdminApi.js"></script>
</html>
