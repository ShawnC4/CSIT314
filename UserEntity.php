<?php
require_once 'UserAcctdb.php';

class UserEntity {
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function findAccByUsername($username, $profile) {
        // Prepare SQL statement
        if ($profile == 'admin') {
            $stmt = $this->conn->prepare("SELECT * FROM sysadmin WHERE username = ?");
            $stmt->bind_param("s", $username);
        } else {
            $stmt = $this->conn->prepare("SELECT * FROM user_accounts WHERE username = ? AND profile_id = ?");
            $stmt->bind_param("si", $username, $profile);
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

    public function getUserProfiles() {
        $profiles = array(); // Initialize an empty array to store profiles

        // Prepare SQL statement to select profiles
        $sql = "SELECT id FROM user_profiles";

        // Execute the query
        $result = $this->conn->query($sql);

        // Check if the query was successful
        if ($result) {
            // Fetch profiles and add them to the array
            while ($row = $result->fetch_assoc()) {
                $profiles[] = $row;
            }
        } else {
            // Handle error if query fails
            echo "Error fetching profiles: " . $this->conn->error;
        }

        // Return the array of profiles
        return $profiles;
    }
}
?>
