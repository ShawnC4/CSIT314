<?php
require_once 'UserAccount.php';
require_once 'UserProfile.php';

class AdminCreateUAController {
    private $entity, $entityP;

    public function __construct () {
        $this->entity = new UserAccount();
        $this->entityP = new UserProfile();
    }

    public function createAccount ($username, $email, $password, $activeStatus, $profile_id) {
        $result = $this->entity->createUserAccount($username, $email, $password, $activeStatus, $profile_id);
        return $result;
    }

    public function getUserProfiles () {
        $profiles = $this->entityP->getUserProfiles();

        return $profiles;
    }
}

?>