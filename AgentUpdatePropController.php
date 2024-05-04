<?php
require_once 'PropertyEntity.php';

class AgentUpdatePropController {
    private $entity;

    public function __construct() {
        $this->entity = new PropertyEntity();
    }

    public function updateProperty ($name, $type, $size, $rooms, $price, $location, $status, $image, $views, $seller_id, $agent_id, $id) {
        $properties = $this->entity->updateAgentProperty($name, $type, $size, $rooms, $price, $location, $status, $image, $views, $seller_id, $agent_id, $id);
        return $properties;
    }
}

?>