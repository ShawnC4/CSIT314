 <!DOCTYPE html>
<html lang="en">
<head>
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin UP Page</title>
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
    <br>
    <button id="createProfile">Create User Profile</button>
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="UpForm">
                <br><input type="text" id="profileName" name="profileName" placeholder="Profile Name" required><br>
                <br><label><input type="checkbox" id="activeStatus" name="activeStatus">Active Status</label><br>
                <br><label for="description">Description:</label><br>
                <input type="text" id="description" name="description" placeholder="Description"><br>
                <br><button id="SubmitUpForm" type="submit">Submit</button><br>
            </form>
        </div>
    </div>
    <form id="UpForm">
    
    </form>
    <br>
    <div id="profileList">
        
    </div>
    <br>
    <a href="logout.php">Logout</a>
</body>
<script src="Admin.js"></script>
<script src="AdminApi.js"></script>
</html>