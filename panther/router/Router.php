<?php

namespace Panther\Router;

use Panther\Router\Interfaces\RouterInterface;
use Panther\Security\Auth;

class Router implements RouterInterface {

    private $collection;
    
    function __construct(){
        $this->collection = new Collection;
    }

	public function run($request, $config){

        $request->url = $request->getUri();
        
        return $this->collection->traverse($request, function($request, $route, $response) {

            // GET Request
            if($request->isGet() && !$response->hasParams){
                return $route->invoke();
            }
            if($request->isGet() && $response->hasParams){
                return $route->invoke($response->params);
            }  

            // POST Request
            if($request->isPost() && !$response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                return Auth::secure($route, $http_request, function($route){
                    return $route->invoke($http_request);
                });                
            }
            if($request->isPost() && $response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                $response->params[] = $http_request;
                return Auth::secure($route, $http_request, function($route) use($response) {
                    return $route->invoke($response->params);
                });                  
            }

            // PUT Request
            if($request->isPut() && !$response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                return $route->invoke($http_request);
            }
            if($request->isPut() && $response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                $response->params[] = $http_request;
                return $route->invoke($response->params);
            }

            // PATCH Request
            if($request->isPatch() && !$response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                return $route->invoke($http_request);
            }
            if($request->isPatch() && $response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                $response->params[] = $http_request;
                return $route->invoke($response->params);
            }

            // DELETE Request
            if($request->isDelete() && !$response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                return $route->invoke($http_request);
            }
            if($request->isDelete() && $response->hasParams){
                $http_request = new \Panther\Http\Request($request->getPostData());
                $response->params[] = $http_request;
                return $route->invoke($response->params);
            }
            
        });

    }
    
    private function make($url, $method, $class, $callable, $secure = false){
        $this->collection->push(new \Panther\Router\Route([
            'method' => $method,
            'url' => $url,
            'class' => $class,
            'type' => ($callable instanceof Closure ? 'closure' : 'function'),
            'callable' => $callable,
            'auth' => $secure
        ]));
    }

    public function get($url, $callable){    	
    	$trace = debug_backtrace();
        $class = $trace[1]['class'];
        $this->make($url, 'GET', $class, $callable);  	
    }

    public function post($url, $callable, $secure = false){    	
    	$trace = debug_backtrace();
        $class = $trace[1]['class'];
        $this->make($url, 'POST', $class, $callable, $secure);     	
    }

    public function put($url, $callable){    	
    	$trace = debug_backtrace();
        $class = $trace[1]['class'];
        $this->make($url, 'PUT', $class, $callable);     	
    }

    public function patch($url, $callable){       
        $trace = debug_backtrace();
        $class = $trace[1]['class'];
        $this->make($url, 'PATCH', $class, $callable);        
    }

    public function delete($url, $callable){    	
    	$trace = debug_backtrace();
        $class = $trace[1]['class'];
        $this->make($url, 'DELETE', $class, $callable);     	
    }

}