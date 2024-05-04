<?php
require_once 'ShortlistEntity.php';
require_once 'PropertyEntity.php';

class SellerViewPropertyController {
    private $entity;
    private $shortlistEntity;

    public function __construct() {
        $this->entity = new PropertyEntity();
        $this->shortlistEntity = new ShortlistEntity();
    }

    public function getSellerProperties($seller) {
        // Retrieve user profiles from the database
        $properties = $this->entity->getSellerProperties($seller);

        return $properties;
    }

    public function getPropertyByID($id) {
        $property = $this->entity->getPropertyById($id);
        $shortlist = $this->shortlistEntity->getCountByProperty($id);
        return ['property' => $property, 'shortlist' => $shortlist];
    }
}
?>
