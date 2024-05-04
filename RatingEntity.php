<?php
require_once 'Konohadb.php';

class RatingEntity {
    private $db, $conn;
    public $rating, $customer_id, $agent_id;

    public function __construct($rating = null, $customer_id = null, $agent_id = null) {
        if ($rating !== null && $customer_id !== null && $agent_id !== null) {
            $this->rating = $rating;
            $this->customer_id = $customer_id;
            $this->agent_id = $agent_id;
        }
    }

    public function getAgentRatings($agent) {
        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();

        $ratings = array(); 

        $sql = "SELECT * FROM ratings WHERE agent_id = '$agent'";

        $result = $this->conn->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $rating = new RatingEntity(
                    $row['rating'],
                    $row['customer_id'],
                    $row['agent_id']
                );
 
                $ratings[] = $rating;
            }
        } else {
            echo "Error fetching ratings: " . $this->conn->error;
        }

        $this->db->closeConn();

        return $ratings;
    }

}
?>