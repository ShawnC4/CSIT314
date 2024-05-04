<?php
require_once 'PropertyEntity.php';

class AgentCreatePropController {
    private $entity;

    public function __construct() {
        $this->entity = new PropertyEntity();
    }

    public function createProperty($Name, $Type, $Size, $Rooms, $Price, $Location, $Status, $Image, $Views, $Seller_id, $Agent_id) {
        $properties = $this->entity->createAgentProperty($Name, $Type, $Size, $Rooms, $Price, $Location, $Status, $Image, $Views, $Seller_id, $Agent_id);
        return $properties;
    }

}

?>