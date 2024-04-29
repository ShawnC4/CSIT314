<?php
require 'UserProfileEntity.php';

class AdminCreateUPController {
    private $entity;

    public function __construct () {
        $this->entity = new UserProfileEntity();
    }

    public function createProfile ($profileName, $activeStatus, $description) {
        $result = $this->entity->createUserProfile($profileName, $activeStatus, $description);
        return $result;
    }

    public function profileExists($profileName) {
        $profiles = $this->entity->getUserProfiles();
        foreach ($profiles as $profile) {
            // Retrieve the name of the profile
            $name = $profile->getName();
            if ($name === $profileName) {
                return ["exists" => true];
            }
        }
        return ["exists" => false];
    }
}

?>