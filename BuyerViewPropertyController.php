<?php
require_once 'PropertyEntity.php';
require_once 'ShortListEntity.php';

class BuyerViewPropertyController {
    private $entity, $entityS;

    public function __construct() {
        $this->entity = new PropertyEntity();
        $this->entityS = new ShortlistEntity();
    }

    public function getBuyerProperties($page) {
        $properties = $this->entity->getBuyerProperties($page);

        return $properties;
    }

    public function getNumberOfPages() {
        $properties = $this->entity->getNumberOfProperties();
        $pages = ceil($properties / 9);
        return $pages;
    }

    public function shortListExists ($propertyId, $buyerId) {
        $exists = $this->entityS->shortListExists($propertyId, $buyerId);
        return $exists;

    }
}
?>