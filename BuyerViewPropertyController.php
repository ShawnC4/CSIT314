<?php
require_once 'PropertyEntity.php';

class BuyerViewPropertyController {
    private $entity;

    public function __construct() {
        $this->entity = new PropertyEntity();
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
}
?>