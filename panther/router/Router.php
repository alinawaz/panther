<?php

namespace Panther\Router;

use \Panther\Router\Interfaces\RouterInterface;

class Router implements RouterInterface {

    private $collection;
    
    function __construct(){
        $this->collection = new Collection;
    }

	public function run($request, $config){

        $request->url = $request->getUri();        
        if($config->has('base_url')){
            $request->url = $request->getUrl();
            $request->url = str_replace($config->get('base_url'), '', $request->url);
        }
        
        return $this->collection->traverse($request, function($request, $route, $response) {

            // POST
            if($request->isPost() && $request->hasPostData() && !$response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                return $route->invoke($http_request);
            }
            // GET with params
            if($request->isGet() && !$request->hasPostData() && $response->hasParams){
                return $route->invoke($response->params);
            }
            // POST with params
            if($request->isPost() && $request->hasPostData() && $response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                $response->params[] = $http_request;
                return $route->invoke($response->params);
            }
            // GET
            if($request->isGet()){
                return $route->invoke();
            }
            
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

    public function put($url, $callable){    	
    	$trace = debug_backtrace();
        $class = $trace[1]['class'];
        $this->make($url, 'PUT', $class, $callable);     	
    }

    public function delete($url, $callable){    	
    	$trace = debug_backtrace();
        $class = $trace[1]['class'];
        $this->make($url, 'DELETE', $class, $callable);     	
    }

}