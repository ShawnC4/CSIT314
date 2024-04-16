<?php
class UserAcc {

    private $id, $username, $password, $email, $profile_id;

    public function __construct($id, $username, $password, $email, $profile_id) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->profile_id = $profile_id;
    }

    public function getUsername () {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }
}
?>