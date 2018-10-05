<?php

namespace Panther\Entity;

use \Panther\Entity\Interfaces\CollectionInterface;

class Collection implements CollectionInterface {

    private $collection;

    function construct($entity_array = []){
        $this->$collection = $entity_array;
    }

    public function push($entity){
        $this->collection[] = $entity;
    }

    public function pop(){
        unset($this->collection[count($this->collection)-1]);
    }

    public function traverse($callable){
        foreach($this->collection as $entity){
            $callable($entity);
        }
    }

}