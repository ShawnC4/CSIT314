<?php
require_once 'Konohadb.php';
require 'PropertyClass.php';

class PropertyEntity {
    private $db, $conn;
    public function __construct() {
        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();
    }
    public function deleteProperty($propertyId) {
        $sql = "DELETE FROM properties WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $propertyId);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function getPropertyById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM property WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        $stmt->execute();
        
        $result = $stmt->get_result();

        $fetchProperty = $result->fetch_assoc();
        
        $stmt->close();
        
        if ($fetchProperty) {
            $property = new Property($fetchProperty['id'], $fetchProperty['name'], $fetchProperty['type'], $fetchProperty['size'], $fetchProperty['rooms'], $fetchProperty['price'], $fetchProperty['location'], $fetchProperty['status'], $fetchProperty['seller_id'], $fetchProperty['agent_id']);
        } else {
            $property = null;
        }

        return $property;
    }

    public function getAgentProperties($agent) {
        $properties = array(); 

        $sql = "SELECT * FROM property WHERE agent_id = '$agent'";

        $result = $this->conn->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $property = new Property(
                    $row['id'],
                    $row['name'],
                    $row['type'],
                    $row['size'],
                    $row['rooms'],
                    $row['price'],
                    $row['location'],
                    $row['status'],
                    $row['seller_id'],
                    $row['agent_id']
                );
 
                $properties[] = $property;
            }
        } else {
            echo "Error fetching properties: " . $this->conn->error;
        }

        return $properties;
    }
    
}
?>