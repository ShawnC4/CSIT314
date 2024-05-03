<?php
require_once 'ShortlistEntity.php';

class SellerViewPropertyController {
    private $propertyEntity;
    private $shortlistEntity;

    public function __construct() {
        $this->propertyEntity = new PropertyEntity();
        $this->shortlistEntity = new ShortlistEntity();
    }

    public function getPropertyByID($id) {
        $property = $this->propertyEntity->getPropertyByID($id);
        $shortlist = $this->shortlistEntity->getCountByProperty($id);
        return ['property' => $property, 'shortlist' => $shortlist];
    }
}
?>
