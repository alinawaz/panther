<?php

namespace Panther\Router;

use \Panther\Router\Interfaces\RouterInterface;

class Router implements RouterInterface {

    private $collection;
    
    function __construct(){
        $this->collection = new Collection;
    }

	public function run($request, $config){

        $request->request_string = $request->getUri();        
        if($config->has('base_url')){
            $request->request_string = $request->getUrl();
            $request->request_string = str_replace($config->get('base_url'), '', $request->request_string);
        }
        
        return $this->collection->traverse($request, function($request, $route, $response) {

            // POST
            if($request->hasPostData() && !$response->hasParams){
                $http_request = new \Panther\Http\Request($_POST);
                return $route->invoke($http_request);
            }
            // GET with params
            if(!$request->hasPostData() && $response->hasParams){
                return $route->invoke($response->params);
            }
            // POST with params
            if($request->hasPostData() && $response->hasParams){
                $http_request = new \Panther\Http\Request($_POST);
                $response->params[] = $http_request;
                return $route->invoke($response->params);
            }
            // GET
            return $route->invoke();
            
        });

    }
    
    private function make($url, $method, $class, $callable){
        $this->collection->push(new \Panther\Router\Route([
            'method' => $method,
            'url' => $url,
            'class' => $class,
            'type' => ($callable instanceof Closure ? 'closure' : 'function'),
            'callable' => $callable
        ]));
    }

    public function get($url, $callable){    	
    	$trace = debug_backtrace();
        $class = $trace[1]['class'];
        $this->make($url, 'GET', $class, $callable);  	
    }

    public function post($url, $callable){    	
    	$trace = debug_backtrace();
        $class = $trace[1]['class'];
        $this->make($url, 'POST', $class, $callable);     	
    }

}