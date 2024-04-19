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

    public function updateUserProfile ($profileId, $profileName, $activeStatus, $description) {
        // Prepare SQL statement to update user profile
        $sql = "UPDATE user_profiles SET name=?, activeStatus=?, description=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        
        // Bind parameters to the statement
        $stmt->bind_param("sisi", $profileName, $activeStatus, $description, $profileId);
    
        // Execute the update query
        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false];
        }
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