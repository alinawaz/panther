<?php

namespace Panther;

class App {

    private $collection;
    private $config;
    private $router;

    function __construct($config = []){
        $this->router = resolve('router')->from('router');
        $this->config = new \Panther\Core\Config($config);
        $global_config = $this->config;
        $this->collection = new \Panther\Entity\Collection;
    }

    public function register($entity_name, $alias = ''){
        $alias = ($alias==''?$entity_name:$alias);        
        $entity_class = "App\\Entities\\".$entity_name;
        $entity = new \Panther\Entity\Entity($alias, new $entity_class());
        $this->collection->push($entity);
    }

    public function run(){
        $router = &$this->router;
        $this->collection->traverse(function($entity) use ($router){
            if(method_exists($entity->get(), 'routes')){
                $entity->get()->routes($router);
            }
        });
        $file_routes = new \App\Routing\Routes($router);
        if(method_exists($file_routes, 'index')){
            $file_routes->index();
        }
        $request = resolve('request')->from('router', $_SERVER);
        echo $this->router->run($request, $this->config);
    }

}