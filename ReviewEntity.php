<?php
require_once 'Konohadb.php';

class ReviewEntity {
    private $db, $conn;
    public $review, $customer_id, $agent_id;

    public function __construct($review = null, $customer_id = null, $agent_id = null) {
        if ($review !== null && $customer_id !== null && $agent_id !== null) {
            $this->review = $review;
            $this->customer_id = $customer_id;
            $this->agent_id = $agent_id;
        }
    }

    public function getAgentReviews($agent) {
        $this->db = new DBconn(); 
        $this->conn = $this->db->getConn();

        $reviews = array(); 

        $sql = "SELECT * FROM reviews WHERE agent_id = '$agent'";

        $result = $this->conn->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $review = new ReviewEntity(
                    $row['review'],
                    $row['customer_id'],
                    $row['agent_id']
                );
 
                $reviews[] = $review;
            }
        } else {
            echo "Error fetching reviews: " . $this->conn->error;
        }

        $this->db->closeConn();

        return $reviews;
    }

}
?>