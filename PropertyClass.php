<?php

class Property {
    public $id, $name, $type, $size, $rooms, $price, $location, $status, $image, $views, $seller_id, $agent_id;

    public function __construct($id, $name, $type, $size, $rooms, $price, $location, $status, $image, $views, $seller_id, $agent_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->size = $size;
        $this->rooms = $rooms;
        $this->price = $price;
        $this->location = $location;
        $this->status = $status;
        $this->image = $image;
        $this->views = $views;
        $this->seller_id = $seller_id;
        $this->agent_id = $agent_id;
    }

    // Getters and Setters for each property
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function getSize() {
        return $this->size;
    }

    public function getRooms() {
        return $this->rooms;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getImage() {
        return $this->image;
    }

    public function getViews() {
        return $this->views;
    }

    public function getSellerId() {
        return $this->seller_id;
    }

    public function getAgentId() {
        return $this->agent_id;
    }
}

?>