<?php
class UserAcc implements JsonSerializable{

    private $id, $username, $password, $email, $profile_id, $activeStatus;

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
	
	public function getEmail() {
        return $this->email;

    }

    public function isActive(){
        return $this->activeStatus;
    }

    public function getProfileId () {
        return $this->profile_id;
    }
	
	public function jsonSerialize() {
		return array(
			'username' => $this->getUsername(),
			'password' => $this->getPassword(),
			'email' => $this->getEmail(),
			'activeStatus' => $this->isActive(),
			'profile_id' => $this->getProfileId()
		);
	}
}
?>