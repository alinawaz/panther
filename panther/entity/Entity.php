<?php

namespace Panther\Entity;

use \Panther\Entity\Interfaces\EntityInterface;

class Entity implements EntityInterface {
    
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