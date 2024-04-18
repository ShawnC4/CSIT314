<?php
require_once 'Konohadb.php';

class UserProfileEntity {
    private $db, $conn;

    public function __construct() {
        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();
    }

    public function createUserProfile ($profileName, $activeStatus, $description) {
        $sql = "INSERT INTO user_profiles VALUES (?, ?, ?)";

        $name = $profileName;
        $active = $activeStatus;
        $desc = $description; 

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sis", $name, $active, $desc);

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
    
}

?>