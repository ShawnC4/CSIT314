// ShortlistEntity.php
<?php

require_once 'Konohadb.php';

class ShortlistEntity {
    private $db, $conn;

    public function __construct() {
        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();
    }

    public function getCountByProperty($id) {
        $sql = "SELECT COUNT(*) AS count FROM shortlist WHERE property_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
        $stmt->close();
        return $count;
    }

    public function closeConn() {
        $this->db->closeConn();
    }
}
?>
