<?php
require_once 'Konohadb.php';

class UserProfileEntity {
    private $db, $conn;

    public function __construct() {
        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();
    }

    public function createUserProfile ($profileName, $activeStatus, $description) {

        $sql = "INSERT INTO user_profiles (name, activeStatus, description) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sis", $profileName, $activeStatus, $description);

        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false];
        }
    }

    public function getUserProfiles() {
        $profiles = array(); // Initialize an empty array to store profiles

        // Prepare SQL statement to select profiles
        $sql = "SELECT * FROM user_profiles";

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

    public function updateUserProfile ($profileId, $profileName, $activeStatus, $description) {
        // Prepare SQL statement to update the user profile
        $sql = "UPDATE user_profiles SET name = ?, activeStatus = ?, description = ? WHERE id = ?";
        
        // Prepare the SQL statement
        $stmt = $this->conn->prepare($sql);
        
        // Bind parameters
        $stmt->bind_param("sisi", $profileName, $activeStatus, $description, $profileId);
        
        // Execute the query
        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false];
        }
    }

    public function suspendUserProfile($profileId) {
        $sql = "UPDATE user_profiles SET activeStatus = 0 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $profileId);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Profile has been suspended successfully.'];
        } else {
            return ['success' => false, 'message' => 'Failed to suspend the profile.'];
        }
    }
    

}

?>