<?php
require_once 'UserAccEntity.php';
require_once 'UserProfileEntity.php';

class AdminViewUAController {
    private $entity, $entityP;

    public function __construct() {
        $this->entity = new UserAccEntity();
        $this->entityP = new UserProfileEntity();
    }

    public function getUserAccounts() {
        // Retrieve user profiles from the database
        $accounts = $this->entity->getUserAccounts();

        return $accounts;
    }

    public function getProfileById ($profile_id) {
        $profile = $this->entityP->findProfileById($profile_id);
        return $profile;
    }
}

?>