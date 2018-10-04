<?php

namespace Panther\Entity;

class Entity {
    
    private $name;
    private $class;
    
    function __construct($name, $class){
        $this->name = $name;
        $this->class = $class;
    }

    public function get(){
        return $this->class;
    }

}