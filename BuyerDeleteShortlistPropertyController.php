<?php
require_once 'ShortListEntity.php';

class BuyerDeleteShortlistPropertyController {
    private $entity;

    public function __construct () {
        $this->entity = new ShortlistEntity();
    }

    public function deleteShortListProperty ($property_id, $buyer_id) {
        $result = $this->entity->deleteShortListProperty($property_id, $buyer_id);
        return $result;
    }
}

?>