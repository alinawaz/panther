<?php

namespace Panther\Router;

use Panther\Core\ErrorView;
use Panther\Router\Interfaces\CollectionInterface;

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
        return ErrorView::render('404 - Not Found', 'Page you are looking for was not found.');
    }

    public function get(){
        return $this->collection;
    }

}