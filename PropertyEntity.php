<?php
require_once 'Konohadb.php';

class PropertyEntity implements JsonSerializable{
    private $db, $conn;
    private $id, $name, $type, $size, $rooms, $price, $location, $status, $image, $views, $seller_id, $agent_id;

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
            $property = new PropertyEntity(
				$fetchProperty['id'], 
				$fetchProperty['name'], 
				$fetchProperty['type'], 
				$fetchProperty['size'], 
				$fetchProperty['rooms'], 
				$fetchProperty['price'], 
				$fetchProperty['location'], 
				$fetchProperty['status'], 
				$fetchProperty['image'], 
				$fetchProperty['views'], 
				$fetchProperty['seller_id'], 
				$fetchProperty['agent_id']
			);
        } else {
            $property = null;
        }

        $this->db->closeConn();

        return $property;
    }

    public function getPropertiesByAgent($agent) {
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
		
			$this->db->closeConn();
            return ['success' => true, 'properties' => $properties];
        } else {
			$errorMessage = $this->conn->error;
			$this->db->closeConn();
            return ['success' => false, 'errorMessage' => $errorMessage];
		}
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
    public function createProperty($Name, $Type, $Size, $Rooms, $Price, $Location, $Status, $Image, $Views, $Seller_id, $Agent_id) {

        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();

        // Prepare SQL statement
        $stmt = $this->conn->prepare("INSERT INTO property (name, type, size, rooms, price, location, status, image, views, seller_id, agent_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Bind parameters
        $stmt->bind_param("ssiidsssiss", $Name, $Type, $Size, $Rooms, $Price, $Location, $Status, $Image, $Views, $Seller_id, $Agent_id);
        
		mysqli_report(MYSQLI_REPORT_STRICT);
		
        // Execute the statement
        if ($stmt->execute()) {
			// Property creation successful
			$this->db->closeConn();
            return ['success' => true];
        } else {
			// Property creation failed
			$errorMessage = $this->conn->error;
			$this->db->closeConn();
            return ['success' => false, 'errorMessage' => $errorMessage];
		}
    }

    // Update Property
    public function updateProperty($name, $type, $size, $rooms, $price, $location, $status, $image, $views, $seller_id, $agent_id, $id) {

        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();

        // Prepare SQL statement
        $stmt = $this->conn->prepare("UPDATE property SET name = ?, type = ?, size = ?, rooms = ?, price = ?, location = ?, status = ?, image = ?, views = ?, seller_id = ?, agent_id = ? WHERE id = ?");
        
        // Bind parameters
        $stmt->bind_param("ssiidsssissi", $name, $type, $size, $rooms, $price, $location, $status, $image, $views, $seller_id, $agent_id, $id);
        
        // Execute the statement
        if ($stmt->execute()) {
			// Property update successful
			$this->db->closeConn();
            return ['success' => true];
        } else {
			// Property update failed
			$errorMessage = $this->conn->error;
			$this->db->closeConn();
            return ['success' => false, 'errorMessage' => $errorMessage];
		}
    }

    public function deleteProperty($propertyId) {
        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();

        $sql = "DELETE FROM property WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            $errorMessage = $this->conn->error;
			$this->db->closeConn();
            return ['success' => false, 'errorMessage' => $errorMessage];
        }

        $stmt->bind_param("i", $propertyId);

        if ($stmt->execute()) {
			// Property delete successful
			$this->db->closeConn();
            return ['success' => true];
        } else {
			// Property delete failed
			$errorMessage = $this->conn->error;
			$this->db->closeConn();
            return ['success' => false, 'errorMessage' => $errorMessage];
		}
    }
	
	public function searchProperty($name, $agent) {
		$this->db = new DBconn(); 
        $this->conn = $this->db->getConn();
		
		$properties = array(); 
		$sql = "SELECT * FROM property WHERE name LIKE CONCAT('%', ?, '%') AND agent_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            $errorMessage = $this->conn->error;
			$this->db->closeConn();
            return ['success' => false, 'errorMessage' => $errorMessage];
        }

        $stmt->bind_param("ss", $name, $agent);

        if ($stmt->execute()) {
			// Property search successful			
			$result = $stmt->get_result();
			
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
			
			$this->db->closeConn();
            return ['success' => true, 'properties' => $properties];
        } else {
			// Property search failed
			$errorMessage = $this->conn->error;
			$this->db->closeConn();
            return ['success' => false, 'errorMessage' => $errorMessage];
		}
	}
	
    public function jsonSerialize() {
		return array(
			'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'size' => $this->size,
            'rooms' => $this->rooms,
            'price' => $this->price,
            'location' => $this->location,
            'status' => $this->status,
            'image' => $this->image,
            'views' => $this->views,
            'seller_id' => $this->seller_id,
            'agent_id' => $this->agent_id
		);
	}	
}
?>