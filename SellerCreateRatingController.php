<?php
require_once 'RatingEntity.php';

class SellerCreateRatingController {
    private $entity;

    public function __construct() {
        $this->entity = new RatingEntity();
    }

    public function createRating($rating, $customer_id, $Agent_id) {
        $ratings = $this->entity->createSaleRating($rating, $customer_id, $Agent_id);
        return $ratings;
    }

}

?>