<?php
require_once 'RatingEntity.php';

class SellerCreateRatingController {
    private $entity;

    public function __construct() {
        $this->entity = new RatingEntity();
    }

    public function createRating($rating, $customer_id, $agent_id) {
        $agentRatings = $this->entity->createSaleRating($rating, $customer_id, $agent_id);
        return $agentRatings;
    }

}

?>