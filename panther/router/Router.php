<?php

namespace Panther\Router;

class Router implements RouterInterface {

	private $routes = [];

	public function run($request, $config){

        $requestString = $request->getUri();
        
        if($config->has('base_url')){
            $requestString = $request->getUrl();
            $requestString = str_replace($config->get('base_url'), '', $requestString);
        }

        $matched = false;
        
        foreach($this->routes as $route){

			$response = RouteMatch::match($requestString, $route, $_SERVER['REQUEST_METHOD']);
            
            if($response->matched){

                $matched = true;

                if($request->hasPostData() && !$response->hasParams){
                    $http_request = new \Panther\Http\Request($_POST);
                    return $route->invoke($http_request);
                }

                if(!$request->hasPostData() && $response->hasParams){
                    return $route->invoke(...$response->params);
                }

                if($request->hasPostData() && $response->hasParams){
                    $http_request = new \Panther\Http\Request($_POST);
                    $response->params[] = $http_request;
                    return $route->invoke(...$response->params);
                }

                return $route->invoke();				
			}
        }
        if(!$matched){
            echo "404";
        }
	}

    public function get($url, $callable){    	
    	$trace = debug_backtrace();
    	$class = $trace[1]['class'];
    	if($callable instanceof Closure){
    		$this->routes[] = new \Panther\Router\Route([
    			'method' => 'GET',
	    		'url' => $url,
	    		'class' => $class,
	    		'type' => 'closure',
	    		'callable' => $callable
	    	]);
    	}else{
    		$this->routes[] = new \Panther\Router\Route([
    			'method' => 'GET',
	    		'url' => $url,
	    		'class' => $class,
	    		'type' => 'function',
	    		'callable' => $callable
	    	]);
    	}    	
    }

    public function post($url, $callable){    	
    	$trace = debug_backtrace();
    	$class = $trace[1]['class'];
    	if($callable instanceof Closure){
    		$this->routes[] = [
    			'method' => 'POST',
	    		'url' => $url,
	    		'class' => $class,
	    		'type' => 'closure',
	    		'callable' => $callable
	    	];
    	}else{
    		$this->routes[] = [
    			'method' => 'POST',
	    		'url' => $url,
	    		'class' => $class,
	    		'type' => 'function',
	    		'callable' => $callable
	    	];
    	}    	
    }

}