<?php
require_once 'PropertyEntity.php';

class AgentViewPropController {
    private $entity;

    public function __construct() {
        $this->entity = new PropertyEntity();
    }

    public function getAgentProperties($agent) {
        // Retrieve user profiles from the database
        $properties = $this->entity->getAgentProperties($agent);

        return $properties;
    }

    public function deleteProperty($propertyId){
        return $this->entity->deleteProperty($propertyId);
    }

    public function getProperty($id) {
        // Retrieve user profiles from the database
        $property = $this->entity->getPropertyById($id);

        return $property;
    }
}

?>