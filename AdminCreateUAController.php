<?php
require 'UserAccEntity.php';

class AdminCreateUAController {
    private $entity;

    public function __construct () {
        $this->entity = new UserAccEntity();
    }

    public function createAccount ($Username, $Email, $Password, $activeStatus, $Profile_id) {
        $result = $this->entity->createUserAccount($Username, $Email, $Password, $activeStatus, $Profile_id);
        return $result;
    }
}

?>