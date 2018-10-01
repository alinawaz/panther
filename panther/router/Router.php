<?php

namespace Panther\Router;

class Router implements RouterInterface {

	private $routes = [];

	public function run($request){
		for ($i=0; $i < count($this->routes); $i++) { 
			$route = $this->routes[$i];
			if($route['url'] == $request){
				$class = new $route['class']();
				$method_name = $route['method'];
				$class->$method_name();
			}
		}
	}

    public function get($url, $method){    	
    	$trace = debug_backtrace();
    	$class = $trace[1]['class'];
    	$this->routes[] = [
    		'url' => $url,
    		'class' => $class,
    		'method' => $method
    	];
    }

}