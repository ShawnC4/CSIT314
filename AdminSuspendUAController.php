<?php
// AdminSuspendUAController.php
require_once 'UserAccEntity.php';

class AdminSuspendUAController {
    private $entity;

    public function __construct() {
        $this->entity = new UserAccEntity();
    }

    public function suspendAccount($accountId) {
        return $this->entity->suspendUserAccount($accountId);
    }
}

?>