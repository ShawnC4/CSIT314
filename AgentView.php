<?php
    require_once 'AgentViewPropController.php';

    $agentViewPropController = new AgentViewPropController();

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getAgentProperties') {

        $properties = $agentViewPropController->getAgentProperties(31);
        header('Content-Type: application/json');

        echo json_encode($properties);
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent View</title>
</head>
<body>
    <h1>Agent View</h1>
    <table>
        <thead>
            <tr>
                <th>Property Name</th>
                <th>Seller ID</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="propertyList">
            
        </tbody>
    </table>
</body>
<script src="AgentViewApi.js"></script>
</html>