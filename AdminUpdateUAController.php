<?php
require_once 'UserAccEntity.php';
require_once 'UserProfileEntity.php';

class AdminUpdateUAController {
    private $entity, $entityP;

    public function __construct () {
        $this->entity = new UserAccEntity();
        $this->entityP = new UserProfileEntity();
    }
	
	public function getUserProfiles () {
        $profiles = $this->entityP->getUserProfiles();

        return $profiles;
    }
	
    public function updateUserAccount($username, $email, $password, $activeStatus, $profile_id) {
        // Call the updateUserAccount method from UserAccEntity
        $result = $this->entity->updateUserAccount($username, $email, $password, $activeStatus, $profile_id);
        
        return $result;
    }
}
?>
