<?php
//Controller class to process log in requests 
require_once 'UserProfileEntity.php';

class AdminSuspendUPController {
    private $entity;

    public function __construct() {
        $this->entity = new UserProfileEntity();
    }

    public function suspendProfile($profileId) {
        $result = $this->entity->suspendUserProfile($profileId);
        return $result;
    }
}
?>
