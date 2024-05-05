<?php
require_once 'UserProfile.php';

class AdminUpdateUPController {
    private $entity;

    public function __construct () {
        $this->entity = new UserProfile();
    }

    public function updateProfile($profileId, $profileName, $activeStatus, $description) {
        $result = $this->entity->updateUserProfile($profileId, $profileName, $activeStatus, $description);
        return $result;
    }
}
?>
