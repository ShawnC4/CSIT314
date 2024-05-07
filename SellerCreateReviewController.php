<?php
require_once 'ReviewEntity.php';

class SellerCreateReviewController {
    private $entity;

    public function __construct() {
        $this->entity = new ReviewEntity();
    }

    public function createReview($review, $customer_id, $agent_id) {
        $agentReviews = $this->entity->createSaleReview($review, $customer_id, $agent_id);
        return $agentReviews;
    }

}

?>