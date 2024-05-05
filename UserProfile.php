<?php
require_once 'Konohadb.php';

class UserProfile {
    private $db, $conn;
	public $id, $name, $activeStatus, $description;
	
	public function __construct($id = null, $name = null, $activeStatus = null, $description = null) {
        if ($id !== null && $name !== null && $activeStatus !== null && $description !== null){
			$this->id = $id;
			$this->name = $name;
			$this->activeStatus = $activeStatus;
			$this->description = $description;
		}
    }
	
	public function startConnection(){
		$this->db = new DBconn(); 
        $this->conn = $this->db->getConn();
	}
	
	public function closeConnection(){
		$this->db->closeConn();
	}

    public function findProfileById($profileId) {
        $this->startConnection();
		// Prepare SQL statement
        $stmt = $this->conn->prepare("SELECT * FROM user_profiles WHERE id = ?");
        $stmt->bind_param("i", $profileId);
        
        $stmt->execute();
        
        // Get result
        $result = $stmt->get_result();

        // Fetch user data
        $fetchuser = $result->fetch_assoc();
        
        // Close statement
        $stmt->close();
        
        if ($fetchuser) {
            $user = new UserProfile($fetchuser['id'], $fetchuser['name'], $fetchuser['activeStatus'], $fetchuser['description']);
        } else {
            $user = null;
        }
		
		$this->closeConnection();

        return $user; // Return user data
    }

    public function createUserProfile ($profileName, $activeStatus, $description) {
		// Check if profile exists
		if ($this->profileExists($profileName)){
            return ['success' => false, 'message' => 'Profile already exists!'];
		}
		
		$this->startConnection();
		
		$sql = "INSERT INTO user_profiles (name, activeStatus, description) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sis", $profileName, $activeStatus, $description);

        if ($stmt->execute()) {
			$this->closeConnection();
            return ['success' => true];
        } else {
			$errorMessage = $this->conn->error;
			$this->closeConnection();
            return ['success' => false, 'message' => 'Error', 'errorMessage' => $errorMessage];
        }
    }
	
	public function profileExists($profileName) {
        $this->startConnection();
		
		$sql = "SELECT COUNT(*) FROM user_profiles WHERE name = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s", $profileName);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		$this->closeConnection();
		
		return $row['COUNT(*)'] > 0;
    }

    public function getUserProfiles() {
        $this->startConnection();
		$profiles = array(); // Initialize an empty array to store profiles

        // Prepare SQL statement to select profiles
        $sql = "SELECT * FROM user_profiles";

        // Execute the query
        $result = $this->conn->query($sql);

        // Check if the query was successful
        if ($result) {
            // Fetch profiles and add them to the array
            while ($row = $result->fetch_assoc()) {
                $profile = new UserProfile(
                    $row['id'],
                    $row['name'],
                    $row['activeStatus'],
                    $row['description']
                );
                // Add the UserProfile object to the array
                $profiles[] = $profile;
                //$profiles[] = $row;
            }
        } else {
            // Handle error if query fails
            echo "Error fetching profiles: " . $this->conn->error;
        }
		
		$this->closeConnection();

        // Return the array of profiles
        return $profiles;
    }

    public function updateUserProfile ($profileId, $profileName, $activeStatus, $description) {
        $this->startConnection();
		// Prepare SQL statement to update the user profile
        $sql = "UPDATE user_profiles SET name = ?, activeStatus = ?, description = ? WHERE id = ?";
        
        // Prepare the SQL statement
        $stmt = $this->conn->prepare($sql);
        
        // Bind parameters
        $stmt->bind_param("sisi", $profileName, $activeStatus, $description, $profileId);
        
        // Execute the query
        if ($stmt->execute()) {
			$this->closeConnection();
            return ['success' => true];
        } else {
			$errorMessage = $this->conn->error;
			$this->closeConnection();
            return ['success' => false, 'errorMessage' => $errorMessage];
        }
    }

    public function suspendUserProfile($profileId) {
        $this->startConnection();
		$sql = "UPDATE user_profiles SET activeStatus = 0 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $profileId);
        
        if ($stmt->execute()) {
			$this->closeConnection();
            return ['success' => true];
        } else {
			$errorMessage = $this->conn->error;
			$this->closeConnection();
            return ['success' => false, 'errorMessage' => $errorMessage];
        }
    }
    

}

?>