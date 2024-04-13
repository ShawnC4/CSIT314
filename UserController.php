<?php
require_once 'UserEntity.php'; 

class UserController {
    public function login($username, $password) {
        $user = new User();
        return $user->authenticate($username, $password);
    }
}
?>
