<?php
require_once 'Konohadb.php';
require 'UserAccClass.php';

class UserAccEntity {
    private $db, $conn;
    public function __construct() {
        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();
    }

    public function findAccByUsername($username, $profile) {
        // Prepare SQL statement
        
        $stmt = $this->conn->prepare("SELECT * FROM user_accounts WHERE username = ? AND profile_id = ?");
        $stmt->bind_param("si", $username, $profile);
        
        $stmt->execute();
        
        // Get result
        $result = $stmt->get_result();

        // Fetch user data
        $fetchuser = $result->fetch_assoc();
        
        // Close statement
        $stmt->close();
        
        if ($fetchuser) {
            $user = new UserAcc($fetchuser['id'], $fetchuser['username'], $fetchuser['password'], $fetchuser['email'], $fetchuser['activeStatus'], $fetchuser['profile_id']);
        } else {
            $user = null;
        }

        return $user; // Return user data
    }

}
?>
