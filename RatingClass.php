<?php

class Rating {
    public $rating, $customer_id, $agent_id;

    public function __construct($rating, $customer_id, $agent_id)
    {
        $this->rating = $rating;
        $this->customer_id = $customer_id;
        $this->agent_id = $agent_id;
    }

    // Getters and Setters for each property
    public function getRating() {
        return $this->rating;
    }

    public function getCustomerId() {
        return $this->customer_id;
    }

    public function getAgentId() {
        return $this->agent_id;
    }

}

?>