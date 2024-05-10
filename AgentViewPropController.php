<?php
require_once 'PropertyEntity.php';

class AgentViewPropController {
    private $entity;

    public function __construct() {
        $this->entity = new PropertyEntity();
    }

    public function getPropertiesByAgent($agent) {
        $properties = $this->entity->getPropertiesByAgent($agent);

        return $properties;
    }
}

?>