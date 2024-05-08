<?php

class Review {
    public $review, $customer_id, $agent_id;

    public function __construct($review, $customer_id, $agent_id)
    {
        $this->review = $review;
        $this->customer_id = $customer_id;
        $this->agent_id = $agent_id;
    }

    // Getters and Setters for each rating
    public function getReview() {
        return $this->review;
    }

    public function getCustomerId() {
        return $this->customer_id;
    }

    public function getAgentId() {
        return $this->agent_id;
    }

}

?>