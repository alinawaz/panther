<?php

namespace Panther;

class App {

    private $entities = [];

    function __construct(){
        $this->router = new \Panther\Router\Router;
    }

    public function register($entity){
        $this->entities[] = $entity;
    }

    public function run(){
        for ($i=0; $i < count($this->entities); $i++) { 
            $entity = $this->entities[$i];
            $class = new $entity['class']();
            $class->routes($this->router);
        }
        echo $this->router->run($_SERVER['REQUEST_URI']);
    }

}