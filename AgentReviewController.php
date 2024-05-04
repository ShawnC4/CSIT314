<?php
require_once 'ReviewEntity.php';


class AgentReviewController {
    private $entity;

    public function __construct() {
        $this->entity = new ReviewEntity();
    }

    public function getAgentReviews($agent) {
        // Retrieve user profiles from the database
        $reviews = $this->entity->getAgentReviews($agent);

        return $reviews;
    }
}
