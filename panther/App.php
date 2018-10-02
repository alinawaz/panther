<?php

namespace Panther;

class App {

    private $entities = [];
    private $config = [];

    function __construct($config = []){
        $this->router = resolve('router')->from('router');
        $this->config = $config;
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
        $request_object = resolve('request')->from('router', $_SERVER);
        echo $this->router->run($request_object, $this->config);
    }

}