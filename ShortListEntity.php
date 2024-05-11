<?php

require_once 'Konohadb.php';

class ShortlistEntity {
    private $db, $conn;
    public $id, $property_id, $buyer_id;

    public function __construct($id = null, $property_id = null, $buyer_id = null) {
        if ($id !== null && $property_id !== null && $buyer_id !== null) {
            $this->id = $id;
            $this->property_id = $property_id;
            $this->buyer_id = $buyer_id;
        }
    }

    public function getCountByProperty($id) {
        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();

        $sql = "SELECT COUNT(*) AS count FROM shortlist WHERE property_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
        $stmt->close();

        $this->db->closeConn();

        return $count;
    }

    public function shortListProperty($property_id, $buyer_id) {
        if ($this->shortListExists($property_id, $buyer_id)) {
            return ['success' => false, 'message' => 'Account already exists!'];
		}

        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();

        $sql = "INSERT INTO shortlist (property_id, buyer_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $property_id, $buyer_id);

        if ($stmt->execute()) {
            $stmt->close();
            $this->db->closeConn();
            return ['success' => true, 'message' => 'Property Shortlisted!'];
        } else {
            $stmt->close();
            $this->db->closeConn();
            return ['success' => false, 'message' => 'Error Shortlisting!'];
        }
    }

    public function shortListExists($property_id, $buyer_id) {
        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();

        $sql = "SELECT * FROM shortlist WHERE property_id = ? AND buyer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $property_id, $buyer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $this->db->closeConn();

        return $result->num_rows > 0;
    }

    public function getShortListProperties($buyer_id) {
        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();
    
        $sql = "SELECT * FROM shortlist WHERE buyer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $buyer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Fetch all shortlisted properties for the buyer
        $properties = [];
        while ($row = $result->fetch_assoc()) {
            $properties[] = $row;
        }
    
        $stmt->close();
        $this->db->closeConn();
    
        return $properties;
    }
    
}
?>
