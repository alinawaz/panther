<?php

namespace Panther\Entity;

//use \Panther\Router\Interfaces\CollectionInterface;

class Collection  {

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

    public function traverse($request, $callable){
        foreach($this->collection as $entity){
            $response = Match::match($route, $request);
            if($response->matched){
                return $callable($request, $route, $response);
            }
        }
        return '404';
    }

}