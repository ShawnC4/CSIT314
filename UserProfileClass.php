<?php
class UserProfile {

    private $id, $name, $activeStatus, $description;

    public function __construct($id, $name, $activeStatus, $description) {
        $this->id = $id;
        $this->name = $name;
        $this->activeStatus = $activeStatus;
        $this->description = $description;
    }

    public function getId () {
        return $this->id;
    }

    public function getName () {
        return $this->name;
    }

    public function isActive(){
        return $this->activeStatus;
    }

    public function getDescription () {
        return $this->description;
    }
}
?>