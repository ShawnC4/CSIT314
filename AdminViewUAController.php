<?php
require_once 'UserAccEntity.php';

class AdminViewUAController {
    private $entity;

    public function __construct() {
        $this->entity = new UserAccEntity();
    }

    public function getUserAccounts() {
        // Retrieve user profiles from the database
        $accounts = $this->entity->getUserAccounts();

        return $accounts;
    }
}

?>