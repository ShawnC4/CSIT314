<?php
require_once 'UserAccount.php';

class AdminSearchUAController {
    private $entity;

    public function __construct() {
        $this->entity = new UserAccount();
    }

    public function searchUserAccount($username) {
        // Retrieve user accounts from the database
        $accounts = $this->entity->searchUserAccount($username);

        return $accounts;
    }
}

?>