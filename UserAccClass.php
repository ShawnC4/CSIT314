<?php
class UserAcc {

    private $id, $username, $password, $email, $profile_id, $activeStatus;

    public function __construct($id, $username, $password, $email, $profile_id, $activeStatus) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->profile_id = $profile_id;
        $this->activeStatus = $activeStatus;
    }

    public function getUsername () {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;

    }

    public function isActive(){
        return $this->activeStatus == 1;
    }
}
?>