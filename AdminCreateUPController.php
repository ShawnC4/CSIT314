<?php
require 'UserProfile.php';

class AdminCreateUPController {
    private $entity;

    public function __construct () {
        $this->entity = new UserProfile();
    }

    public function createProfile ($profileName, $activeStatus, $description) {
        $result = $this->entity->createUserProfile($profileName, $activeStatus, $description);
        return $result;
    }
}

?>