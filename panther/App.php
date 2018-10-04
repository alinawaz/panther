<?php

namespace Panther;

class App {

    private $entities = [];
    private $config = [];

    function __construct($config = []){
        $this->router = resolve('router')->from('router');
        $this->config = new \Panther\Core\Config($config);
        $global_config = $this->config;
    }

    public function register($entity_name, $alias = ''){
        if($alias=='')
        {
            $alias = $entity_name;
        }
        $entity_class = "App\\Entities\\".$entity_name;
        $entity = new \Panther\Entity\Entity($alias, new $entity_class());
        $this->entities[] = $entity;
    }

    public function run(){
        for ($i=0; $i < count($this->entities); $i++) { 
            $entity = $this->entities[$i];
            $class = $entity->get();
            $class->routes($this->router);
        }
        $request_object = resolve('request')->from('router', $_SERVER);
        echo $this->router->run($request_object, $this->config);
    }

}