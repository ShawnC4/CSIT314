<?php
require_once 'Konohadb.php';

class UserProfileEntity {
    private $db, $conn;

    public function __construct() {
        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();
    }

    public function createUserProfile ($profileName, $createPermission, $readPermission, $updatePermission, $deletePermission) {
        $sql = "INSERT INTO user_profiles VALUES (?, ?, ?, ?, ?, ?)";

        $id = strtolower($profileName);
        $name = $profileName;
        $create_listing = $createPermission; 
        $read_listing = $readPermission; 
        $update_listing = $updatePermission; 
        $delete_listing = $deletePermission; 
        echo false;

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssiiii", $id, $name, $create_listing, $read_listing, $update_listing, $delete_listing);

        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false];
        }
    }
}

?>