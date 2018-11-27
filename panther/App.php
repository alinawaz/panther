<?php

namespace Panther;

class App {

    private $collection;
    private $config;
    private $router;

    function __construct(){
        session_start();
        $this->router = resolve('router.router');
        $this->config = new \Panther\Core\Config();
        $this->config->setup();
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
        $request = resolve('router.request', $_SERVER);
        echo $this->router->run($request, $this->config);
    }

}