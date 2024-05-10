<?php
require_once 'RatingEntity.php';


class AgentRatingController {
    private $entity;

    public function __construct() {
        $this->entity = new RatingEntity();
    }

    public function getAgentRatings($agent) {
        // Retrieve user profiles from the database
        $ratings = $this->entity->getAgentRatings($agent);

        return $ratings;
    }
}

?>