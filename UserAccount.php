<?php
require_once 'Konohadb.php';

class UserAccount implements JsonSerializable{
    private $db, $conn;
	private $username, $password, $email, $profile_id, $activeStatus;
	
	public function __construct($username = null, $password = null, $email = null, $activeStatus = null, $profile_id = null) {		
		if($username !== null && $password !== null && $email !== null && $activeStatus !== null && $profile_id !== null){
			$this->username = $username;
			$this->password = $password;
			$this->email = $email;
			$this->activeStatus = $activeStatus;
			$this->profile_id = $profile_id;
		}
    }
	
	public function getUsername () {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;

    }
	
	public function getEmail() {
        return $this->email;

    }

    public function isActive(){
        return $this->activeStatus;
    }

    public function getProfileId () {
        return $this->profile_id;
    }

	public function startConnection(){
		$this->db = new DBconn(); 
        $this->conn = $this->db->getConn();
	}
	
	public function closeConnection(){
		$this->db->closeConn();
	}

    public function findAccById($username) {
		$this->startConnection();
		// Prepare SQL statement
        $stmt = $this->conn->prepare("SELECT * FROM user_accounts WHERE username = ?");
        $stmt->bind_param("s", $username);
        
        $stmt->execute();
        
        // Get result
        $result = $stmt->get_result();

        // Fetch user data
        $fetchuser = $result->fetch_assoc();
        
        // Close statement
        $stmt->close();
        
        if ($fetchuser) {
            $user = new UserAccount($fetchuser['username'], $fetchuser['password'], $fetchuser['email'], $fetchuser['activeStatus'], $fetchuser['profile_id']);
        } else {
            $user = null;
        }

		$this->closeConnection();
		
        return $user; // Return user data
    }

    public function findAccByUsername($username, $profile) {
		$this->startConnection();
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
            $user = new UserAccount($fetchuser['username'], $fetchuser['password'], $fetchuser['email'], $fetchuser['activeStatus'], $fetchuser['profile_id']);
        } else {
            $user = null;
        }
		
		$this->closeConnection();

        return $user; // Return user data
    }

    public function getUserAccounts($page = 0) {
        $this->startConnection();
		
		$accounts = array(); 
		
		$page *= 25;
        // Prepare SQL statement to select profiles
        $sql = "SELECT * FROM user_accounts ORDER BY username ASC LIMIT 25 OFFSET ?";
		$stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $page);
		
        // Execute the query    
        if ($stmt->execute()) {
			$result = $stmt->get_result();
			
			while ($row = $result->fetch_assoc()) {
                $account = new UserAccount(
                    $row['username'],
                    $row['password'],
                    $row['email'],
                    $row['activeStatus'],
                    $row['profile_id']
                );
 
                $accounts[] = $account;
            }
			
			$this->closeConnection();
			$pageCount = $this->getCountUA();
            return ['success' => true, 'accounts' => $accounts, 'count' => $pageCount];
        } else {
			$errorMessage = $this->conn->error;
			$this->closeConnection();
            return ['success' => false, 'errorMessage' => $errorMessage];
        }
    }
	
	public function getCountUA(){
		$this->startConnection();
		// Prepare SQL statement to select profiles
		$sql = "SELECT * FROM user_accounts;";

		// Execute the query
		$result = $this->conn->query($sql);

		// Check if the query was successful
		if ($result) {
			$row = $result->fetch_assoc();
			// Count the rows (using mysqli_num_rows)
			$count = intval(ceil(mysqli_num_rows($result) / 25));
			$this->closeConnection();
			return $count;
		} else {
            // Handle error if query fails
            $errorMessage = $this->conn->error;
			$this->closeConnection();
            return 1;
        }
	}
	

    public function createUserAccount($username, $email, $password, $activeStatus, $profile_id) {
        // Check if profile exists
		if ($this->accountExists($username)){
            return ['success' => false, 'message' => 'Account already exists!'];
		}
		
		$this->startConnection();
		// Prepare SQL statement
        $stmt = $this->conn->prepare("INSERT INTO user_accounts (username, email, password, activeStatus, profile_id) VALUES (?, ?, ?, ?, ?)");
        
        // Bind parameters
        $stmt->bind_param("sssii", $username, $email, $password, $activeStatus, $profile_id);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Account creation successful
			$this->closeConnection();
            return ['success' => true];
        } else {
            // Account creation failed
			$errorMessage = $this->conn->error;
			$this->closeConnection();
            return ['success' => false, 'message' => 'Error', 'errorMessage' => $errorMessage];
        }
    }
	
	public function accountExists($username) {
        $this->startConnection();
		
		$sql = "SELECT COUNT(*) FROM user_accounts WHERE username = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		$this->closeConnection();
		
		return $row['COUNT(*)'] > 0;
    }

    // Update user account
    public function updateUserAccount($username, $email, $password, $activeStatus, $profile_id) {
        $this->startConnection();
		// Prepare SQL statement
        $stmt = $this->conn->prepare("UPDATE user_accounts SET email = ?, password = ?, activeStatus = ?, profile_id = ? WHERE username = ?");
        
        // Bind parameters
        $stmt->bind_param("ssiis", $email, $password, $activeStatus, $profile_id, $username);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Account update successful
			$this->closeConnection();
            return ['success' => true];
        } else {
            // Account update failed
			$errorMessage = $this->conn->error;
			$this->closeConnection();
            return ['success' => false, 'errorMessage' => $errorMessage];
        }
    }
	
	public function searchUserAccount($username){
		$this->startConnection();
		$sql = "SELECT * FROM user_accounts WHERE username LIKE CONCAT('%', ?, '%')";
		$stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
		
		$accounts = array(); 
    
        if ($stmt->execute()) {
			$result = $stmt->get_result();
			
			while ($row = $result->fetch_assoc()) {
                $account = new UserAccount(
                    $row['username'],
                    $row['password'],
                    $row['email'],
                    $row['activeStatus'],
                    $row['profile_id']
                );
 
                $accounts[] = $account;
            }
			
			$this->closeConnection();
            return ['success' => true, 'accounts' => $accounts];
        } else {
			$errorMessage = $this->conn->error;
			$this->closeConnection();
            return ['success' => false, 'errorMessage' => $errorMessage];
        }
	}

    //Suspend user for userAccount
    public function suspendUserAccount($username) {
        $this->startConnection();
		$sql = "UPDATE user_accounts SET activeStatus = 0 WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
    
        if ($stmt->execute()) {
			$this->closeConnection();
            return ['success' => true];
        } else {
			$errorMessage = $this->conn->error;
			$this->closeConnection();
            return ['success' => false, 'errorMessage' => $errorMessage];
        }
    }
	
	public function jsonSerialize() {
		return array(
			'username' => $this->getUsername(),
			'password' => $this->getPassword(),
			'email' => $this->getEmail(),
			'activeStatus' => $this->isActive(),
			'profile_id' => $this->getProfileId()
		);
	}
}
?>
