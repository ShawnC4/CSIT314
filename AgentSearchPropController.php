<?php
require_once 'PropertyEntity.php';

class AgentSearchPropController {
    private $entity;

    public function __construct() {
        $this->entity = new PropertyEntity();
    }

    public function searchProperty($name, $agent){
        return $this->entity->searchProperty($name, $agent);
    }
}

?>