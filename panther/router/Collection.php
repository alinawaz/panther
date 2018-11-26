<?php

namespace Panther\Router;

use \Panther\Router\Interfaces\CollectionInterface;

class Collection implements CollectionInterface {

    private $collection;

    function construct($route_array = []){
        $this->$collection = $route_array;
    }

    public function push($route){
        $this->collection[] = $route;
    }

    public function pop(){
        unset($this->collection[count($this->collection)-1]);
    }

    public function traverse($request, $callable){
        foreach($this->collection as $route){
            $response = Match::match($route, $request);
            if($response->matched){
                return $callable($request, $route, $response);
            }
        }
        return '<link href="/public/css/bootstrap.min.css" rel="stylesheet"/><div class="jumbotron">
  <h1 class="display-4">404 - Not Found</h1>
  <p class="lead">Page you are looking for was not found.</p>
</div>';
    }

    public function get(){
        return $this->collection;
    }

}