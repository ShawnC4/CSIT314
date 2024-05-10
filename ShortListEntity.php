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

    public function getShortlistedProperties($id) {
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
}
?>
