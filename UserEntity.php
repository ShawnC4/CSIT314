<?php
require_once 'SysAdminDB.php';

class UserEntity {
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getUserByUsername($username) {
        // Prepare SQL statement
        $stmt = $this->conn->prepare("SELECT * FROM user_accounts WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        
        // Get result
        $result = $stmt->get_result();

        // Fetch user data
        $user = $result->fetch_assoc();
        
        // Close statement
        $stmt->close();
        
        return $user; // Return user data
    }
}
?>
