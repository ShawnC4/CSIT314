<?php
class UserAcc {

    public $username, $password, $email, $profile_id, $activeStatus;

    public function __construct($username, $password, $email, $activeStatus, $profile_id) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->activeStatus = $activeStatus;
        $this->profile_id = $profile_id;
    }

    public function getUsername () {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;

    }

    public function isActive(){
        return $this->activeStatus;
    }

    public function getProfileId () {
        return $this->profile_id;
    }
}
?>