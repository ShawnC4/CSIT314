<?php
require_once 'PropertyEntity.php';

class AgentDeletePropController {
    private $entity;

    public function __construct() {
        $this->entity = new PropertyEntity();
    }

    public function deleteProperty($propertyId){
        return $this->entity->deleteProperty($propertyId);
    }
}

?>