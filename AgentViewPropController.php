<?php
require_once 'PropertyEntity.php';
require_once 'UserAccEntity.php';

class AgentViewPropController {
    private $entity, $entityU;

    public function __construct() {
        $this->entity = new PropertyEntity();
        $this->entityU = new UserAccEntity();
    }

    public function getAgentProperties($id) {
        // Retrieve user profiles from the database
        $properties = $this->entity->getAgentProperties($id);

        return $properties;
    }

    public function getSellerName($id) {
        // Retrieve user profiles from the database
        $seller = $this->entityU->findAccById($id);

        return $seller;
    }
}

?>