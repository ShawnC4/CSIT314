<?php
// Controller class to process login requests
require_once 'UserAccEntity.php';
require_once 'UserAccClass.php';
require_once 'UserProfileEntity.php';
require_once 'UserProfileClass.php';

class LoginController {
    private $entity, $entityP;

    public function __construct() {
        // Initialize Entity object
        $this->entity = new UserAccEntity();
        $this->entityP = new UserProfileEntity();
    }

    public function auth($username, $password, $profile) {
        // Retrieve user data from the database based on the provided username
        $userA = $this->entity->findAccByUsername($username, $profile);
        
        if ($userA && $password == $userA->getPassword()) {
            if ($userA->isActive()) {
                $userP = $this->entityP->findProfileById($userA->getProfileId());
                if ($userP && $userP->isActive()) {
                    return ["success" => true];
                } else {
                    return ["success" => false, "error" => "Your profile has been suspended. You cannot log in."];
                }
            } else {
                return ["success" => false, "error" => "Your account has been suspended. You cannot log in."];
            }
        } else {
            return ["success" => false, "error" => "Invalid username or password"];
        }
    }
    
    public function getUserProfiles() {
        // Retrieve user profiles from the database
        $profiles = $this->entityP->getUserProfiles();

        return $profiles;
    }
}

// Instantiate Controller object
/*$controller = new LoginController();

// Handle POST request to authenticate user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'login') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    $username = $requestData['username'];
    $password = $requestData['password'];
    $profile = $requestData['profile'];

    // Perform login authentication
    $response = $controller->auth($username, $password, $profile);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getProfiles') {
    $profiles = $controller->getUserProfiles();

    header('Content-Type: application/json');
    echo json_encode($profiles);
}*/
?>