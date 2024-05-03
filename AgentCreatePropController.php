<?php
require_once 'PropertyEntity.php';

class AgentCreatePropController {
    private $entity;

    public function __construct() {
        $this->entity = new PropertyEntity();
    }

    public function createProperty($Name, $Type, $Size, $Rooms, $Price, $Location, $Status, $Seller_id, $Agent_id) {
        // Retrieve user profiles from the database
        $properties = $this->entity->createAgentProperty($Name, $Type, $Size, $Rooms, $Price, $Location, $Status, $Seller_id, $Agent_id);

        return $properties;
    }

}

?>