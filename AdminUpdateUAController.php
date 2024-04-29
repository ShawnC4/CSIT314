<?php
require_once 'UserAccEntity.php';

class AdminUpdateUAController {
    private $entity;

    public function __construct () {
        $this->entity = new UserAccEntity();
    }

    public function updateUserAccount($username, $email, $password, $activeStatus, $id) {
        // Call the updateUserAccount method from UserAccEntity
        $result = $this->entity->updateUserAccount($username, $email, $password, $activeStatus, $id);
        
        return $result;
    }
}
?>
