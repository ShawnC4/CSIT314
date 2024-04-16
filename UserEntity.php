<?php
require_once 'UserAcctdb.php';

class UserEntity {
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function findAccByUsername($username, $profile) {
        // Prepare SQL statement
        switch ($profile) {
            case 'buyer':
                $profile_id = 1;
                break;
            case 'seller':
                $profile_id = 2;
                break;
            case 'agent':
                $profile_id = 3;
                break;
            case 'admin':
                $profile_id = 4;
                break;
            default:
                $profile_id = 404;
        }

        if ($profile_id == 4) {
            $stmt = $this->conn->prepare("SELECT * FROM sysadmin WHERE username = ?");
            $stmt->bind_param("s", $username);
        } else {
            $stmt = $this->conn->prepare("SELECT * FROM user_accounts WHERE username = ? AND profile_id = ?");
            $stmt->bind_param("si", $username, $profile_id);
        }
        
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
