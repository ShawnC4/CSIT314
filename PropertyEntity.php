<?php
require_once 'Konohadb.php';
require 'PropertyClass.php';

class PropertyEntity {
    private $db, $conn;
    public $id, $name, $type, $size, $rooms, $price, $location, $status, $image, $views, $seller_id, $agent_id;

    public function __construct($id = null, $name = null, $type = null, $size = null, $rooms = null, $price = null, $location = null, $status = null, $image = null, $views = null, $seller_id = null, $agent_id = null) {
        if ($id !== null && $name !== null && $type !== null && $size !== null && $rooms !== null && $price !== null && $location !== null && $status !== null && $image !== null && $views !== null && $seller_id !== null && $agent_id !== null) {
            $this->id = $id;
            $this->name = $name;
            $this->type = $type;
            $this->size = $size;
            $this->rooms = $rooms;
            $this->price = $price;
            $this->location = $location;
            $this->status = $status;
            $this->image = $image;
            $this->views = $views;
            $this->seller_id = $seller_id;
            $this->agent_id = $agent_id;
        }
        
    }
    
    public function getPropertyById($id) {
        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();

        $stmt = $this->conn->prepare("SELECT * FROM property WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        $stmt->execute();
        
        $result = $stmt->get_result();

        $fetchProperty = $result->fetch_assoc();
        
        $stmt->close();
        
        if ($fetchProperty) {
            $property = new PropertyEntity($fetchProperty['id'], $fetchProperty['name'], $fetchProperty['type'], $fetchProperty['size'], $fetchProperty['rooms'], $fetchProperty['price'], $fetchProperty['location'], $fetchProperty['status'], $fetchProperty['image'], $fetchProperty['views'], $fetchProperty['seller_id'], $fetchProperty['agent_id']);
        } else {
            $property = null;
        }

        $this->db->closeConn();

        return $property;
    }

    public function getAgentProperties($agent) {
        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();

        $properties = array(); 

        $sql = "SELECT * FROM property WHERE agent_id = '$agent'";

        $result = $this->conn->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $property = new PropertyEntity(
                    $row['id'],
                    $row['name'],
                    $row['type'],
                    $row['size'],
                    $row['rooms'],
                    $row['price'],
                    $row['location'],
                    $row['status'],
                    $row['image'],
                    $row['views'],
                    $row['seller_id'],
                    $row['agent_id']
                );
 
                $properties[] = $property;
            }
        } else {
            echo "Error fetching properties: " . $this->conn->error;
        }

        $this->db->closeConn();

        return $properties;
    }

    public function getSellerProperties($seller) {
        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();

        $properties = array(); 

        $sql = "SELECT * FROM property WHERE seller_id = '$seller'";

        $result = $this->conn->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $property = new PropertyEntity(
                    $row['id'],
                    $row['name'],
                    $row['type'],
                    $row['size'],
                    $row['rooms'],
                    $row['price'],
                    $row['location'],
                    $row['status'],
                    $row['image'],
                    $row['views'],
                    $row['seller_id'],
                    $row['agent_id']
                );
 
                $properties[] = $property;
            }
        } else {
            echo "Error fetching properties: " . $this->conn->error;
        }

        $this->db->closeConn();

        return $properties;
    }

    // Create Property
    public function createAgentProperty($Name, $Type, $Size, $Rooms, $Price, $Location, $Status, $Image, $Views, $Seller_id, $Agent_id) {

        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();

        // Prepare SQL statement
        $stmt = $this->conn->prepare("INSERT INTO property (name, type, size, rooms, price, location, status, image, views, seller_id, agent_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Bind parameters
        $stmt->bind_param("ssiidsssiss", $Name, $Type, $Size, $Rooms, $Price, $Location, $Status, $Image, $Views, $Seller_id, $Agent_id);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Property creation successful
            return true;
        } else {
            // Property creation failed
            return false;
        }
        
        // Close statement
        $stmt->close();
    }

    // Update Property
    public function updateAgentProperty($name, $type, $size, $rooms, $price, $location, $status, $image, $views, $seller_id, $agent_id, $id) {

        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();

        // Prepare SQL statement
        $stmt = $this->conn->prepare("UPDATE property SET name = ?, type = ?, size = ?, rooms = ?, price = ?, location = ?, status = ?, image = ?, views = ?, seller_id = ?, agent_id = ? WHERE id = ?");
        
        // Bind parameters
        $stmt->bind_param("ssiidsssissi", $name, $type, $size, $rooms, $price, $location, $status, $image, $views, $seller_id, $agent_id, $id);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Property update successful
            return true;
        } else {
            // Property update failed
            return false;
        }
        
        // Close statement
        $stmt->close();
    }

    public function deleteProperty($propertyId) {
        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();

        $sql = "DELETE FROM property WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Unable to prepare statement: " . $this->conn->error);
        }

        $stmt->bind_param("i", $propertyId);

        if ($stmt->execute()) {
            $stmt->close();
            return true; // Return true if the deletion was successful
        } else {
            $stmt->close();
            return false; // Return false if the deletion failed
        }

        $this->db->closeConn();
    }
    
}
?>