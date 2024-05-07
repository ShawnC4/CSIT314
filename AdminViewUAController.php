<?php
require_once 'UserAccount.php';
require_once 'UserProfile.php';

class AdminViewUAController {
    private $entity, $entityP;

    public function __construct() {
        $this->entity = new UserAccount();
        $this->entityP = new UserProfile();
    }

    public function getUserAccounts($page=0) {
        // Retrieve user profiles from the database
        $accounts = $this->entity->getUserAccounts($page);

        return $accounts;
    }

    public function getProfileById ($profile_id) {
        $profile = $this->entityP->findProfileById($profile_id);
        return $profile;
    }
}

?>