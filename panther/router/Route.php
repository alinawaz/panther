<?php

namespace Panther\Router;

use \Panther\Router\Interfaces\RouteInterface;

class Route implements RouteInterface {

    private $method;
    private $url;
    private $class;
    private $type;
    private $callable;
    private $auth = false;

	function __construct($route = []){
        if(count($route)>0){
            foreach($route as $key => $value){
                if($key == 'class'){
                    if($value != 'App\Routing\Routes'){ // Ignore main routing file
                        $this->$key = new $value;
                    }
                }else{
                    $this->$key = $value;
                }
            }
        }else{
            throw new Exception("Empty route array passed!");
        }
    }

    public function invoke($params = []){
        if($this->type == 'function'){
            $method = $this->callable;
            if (strpos($method, '@') !== false) {
                $chunks = explode('@', $method);
                $class = "\\App\\Entities\\".$chunks[0];
                $class = new $class;
                $method = $chunks[1];
                return $class->$method(...$params);
            }else{
                return $this->class->$method(...$params);
            }
        }else if($this->type == 'closure'){
            $method = $this->getCallable();
            return $method(...$params);
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

    public function setAuth($auth){
        $this->auth = $auth;
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

    public function getAuth(){
        return $this->auth;
    }

}