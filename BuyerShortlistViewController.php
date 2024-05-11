<?php
require_once 'ShortListEntity.php';
require_once 'PropertyEntity.php';

class BuyerShortListViewController {
    private $entity , $entityP;

    public function __construct () {
        $this->entity = new ShortlistEntity();
        $this->entityP = new PropertyEntity();
    }

    public function getNumberOfPages($buyer_id) {
        $properties = $this->entity->getNumberOfProperties($buyer_id);
        $pages = ceil($properties / 9);
        return $pages;
    }

    public function getBuyerShortlistProperties($page, $buyer_id) {
        $properties = $this->entityP->getBuyerShortlistProperties($page, $buyer_id);
        return $properties;
    }
}

?>