<?php
// Controller class to process login requests
require_once 'UserProfileEntity.php';

class AdminViewUPController {
    private $entity;

    public function __construct() {
        // Initialize Entity object
        $this->entity = new UserProfileEntity();
    }

    public function getUserProfiles() {
        // Retrieve user profiles from the database
        $profiles = $this->entity->getUserProfiles();

        return $profiles;
    }
}

?>