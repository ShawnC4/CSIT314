<?php
require_once 'ShortlistEntity.php';

class BuyerShortlistController {
    private $shortlistEntity;

    public function __construct() {
        $this->shortlistEntity = new ShortlistEntity();
    }

    public function getShortlistedProperties($id) {
        return $this->shortlistEntity->getShortlistedProperties($id);
    }
}
?>