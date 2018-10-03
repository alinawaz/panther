<?php

namespace Panther\Router;

class Route implements RouteInterface {

    private $route = [
        'method' => 'GET',
        'url' => '/test',
        'class' => 'Test\Entities\TestEntity',
        'type' => 'function',
        'callable' => 'test_get'
    ];

    private $method;
    private $url;
    private $class;
    private $type;
    private $callable;

	function __construct($route = []){
        if(count($route)>0){
            if(isset($route['method'])){
                $this->method = $route['method'];
            }else{
                throw new Exception("Route method not found!");
            }
            if(isset($route['url'])){
                $this->url = $route['url'];
            }else{
                throw new Exception("Route url not found!");
            }
            if(isset($route['class'])){
                $this->class = new $route['class']();
            }else{
                throw new Exception("Route class not found!");
            }
            if(isset($route['type'])){
                $this->type = $route['type'];
            }else{
                throw new Exception("Route type not found!");
            }
            if(isset($route['callable'])){
                $this->callable = $route['callable'];
            }else{
                throw new Exception("Route callable not found!");
            }
        }else{
            throw new Exception("Empty route array passed!");
        }
    }

    public function invoke($params = []){
        if($this->type == 'function'){
            $method = $this->callable;
            return $this->class->$method(...$params);
        }else if($this->type == 'closure'){
            return $this->callable(...$params);
        }
    }

    // Setters

    public function setMethod($method){
        $this->method = $method;
    }

    public function setUrl($url){
        $this->url = $url;
    }

    public function setClass($class){
        $this->class = $class;
    }

    public function setType($type){
        $this->type = $type;
    }

    public function setCallable($callable){
        $this->callable = $callable;
    }

    // Getters

    public function getMethod(){
        return $this->method;
    }

    public function getUrl(){
        return $this->url;
    }

    public function getClass(){
        return $this->class;
    }

    public function getType(){
        return $this->type;
    }

    public function getCallable(){
        return $this->callable;
    }

}