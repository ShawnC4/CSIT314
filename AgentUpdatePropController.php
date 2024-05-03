<?php
require_once 'PropertyEntity.php';

class AgentUpdatePropController {
    private $entity;

    public function __construct() {
        $this->entity = new PropertyEntity();
    }

    public function updateProfile($name, $type, $size, $rooms, $price, $location, $status, $seller_id, $agent_id, $id) {
        $result = $this->entity->updateAgentProperty($name, $type, $size, $rooms, $price, $location, $status, $seller_id, $agent_id, $id);
        return $result;
    }
}

?>