<?php
require_once 'ShortListEntity.php';

class BuyerShortListPropertyController {
    private $entity;

    public function __construct () {
        $this->entity = new ShortlistEntity();
    }

    public function shortListProperty ($property_id, $buyer_id) {
        $result = $this->entity->shortListProperty($property_id, $buyer_id);
        return $result;
    }

    public function getShortListProperties($buyer_id) {
        $properties = $this->entity->getShortListProperties($buyer_id);
        return $properties;
    }
}

?>