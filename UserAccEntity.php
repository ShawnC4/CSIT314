<?php
require_once 'Konohadb.php';
require 'UserAccClass.php';

class UserAccEntity {
    private $db, $conn;
    public function __construct() {
        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();
    }

    public function findAccById($id) {
        // Prepare SQL statement
        $stmt = $this->conn->prepare("SELECT * FROM user_accounts WHERE id = ?");
        $stmt->bind_param("i", $id);
        
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

    public function getUserAccounts() {
        $accounts = array(); 

        // Prepare SQL statement to select profiles
        $sql = "SELECT * FROM user_accounts";

        // Execute the query
        $result = $this->conn->query($sql);

        // Check if the query was successful
        if ($result) {

            while ($row = $result->fetch_assoc()) {
                $account = new UserAcc(
                    $row['id'],
                    $row['username'],
                    $row['password'],
                    $row['email'],
                    $row['activeStatus'],
                    $row['profile_id']
                );
 
                $accounts[] = $account;
            }
        } else {
            // Handle error if query fails
            echo "Error fetching accounts: " . $this->conn->error;
        }

        // Return the array of profiles
        return $accounts;
    }

    public function createUserAccount($Username, $Email, $Password, $activeStatus, $Profile_id) {
        // Prepare SQL statement
        $stmt = $this->conn->prepare("INSERT INTO user_accounts (username, email, password, activeStatus, profile_id) VALUES (?, ?, ?, ?, ?)");
        
        // Bind parameters
        $stmt->bind_param("sssii", $Username, $Email, $Password, $activeStatus, $Profile_id);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Account creation successful
            return true;
        } else {
            // Account creation failed
            return false;
        }
        
        // Close statement
        $stmt->close();
    }

    //Suspend user for userAccount
    public function suspendUserAccount($accountId) {
        $sql = "UPDATE user_accounts SET activeStatus = 0 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $accountId);
    
        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true, 'message' => 'Account has been suspended successfully.'];
        } else {
            $stmt->close();
            return ['success' => false, 'message' => 'Failed to suspend the account.'];
        }
    }
    

}
?>
