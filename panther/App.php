<?php

namespace Panther;

class App {

    private $entities = [];

    public function register($entity){
        $this->entities[] = $entity;
    }

    public function run(){
        for ($i=0; $i < count($this->entities); $i++) { 
            $entity = $this->entities[$i];
            if(isset($entity['default']) && $entity['default']){
                var_dump($entity['class']);
            }
        }
    }

}