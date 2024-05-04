<?php
require_once 'AgentCreatePropController.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $Name = $_POST['name'];
    $Type = $_POST['type'];
    $Size = $_POST['sqfeet'];
    $Rooms = $_POST['rooms'];
    $Price = $_POST['price'];
    $Location = $_POST['location'];
    $Status = "available"; // Default status
    $Image = ""; // Placeholder for image file path, to be filled below
    $Views = 0; // Default views
    $Seller_id = $_POST['seller'];
    $Agent_id = "agent_1";

    // Handle image upload
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/"; // Directory where the image will be uploaded
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file); // Move the uploaded file to the target directory
        $Image = $target_file; // Save the file path to the image column in the database
    }

    // Create instance of AgentCreatePropController
    $agentCreatePropController = new AgentCreatePropController();

    // Create property using the controller
    $response = $agentCreatePropController->createProperty($Name, $Type, $Size, $Rooms, $Price, $Location, $Status, $Image, $Views, $Seller_id, $Agent_id);

    // Check if property creation was successful
    if ($response) {
        echo "Property created successfully.";
    } else {
        echo "Error creating property.";
    }
}
?>
