<?php
require_once 'PropertyEntity.php';

class BuyerSearchPropertyController {
    private $entity;

    public function __construct() {
        $this->entity = new PropertyEntity();
    }

    public function searchBuyerProperty($status, $name, $pageNum) {
        return $this->entity->searchBuyerProperty($status, $name, $pageNum);
    }
}

?>