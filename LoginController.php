<?php
session_start();
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
                    $_SESSION['userID'] = $userA->getUsername();
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

?>