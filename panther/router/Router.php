<?php

namespace Panther\Router;

class Router implements RouterInterface {

	private $routes = [];

	public function run($router_request, $config){
        $request = $router_request->getUri();
        if(isset($config['base_url']) && $config['base_url'] != ''){
            $request = $router_request->getUrl();
            $request = str_replace($config['base_url'], '', $request);
        }
		for ($i=0; $i < count($this->routes); $i++) { 
			$route = $this->routes[$i];
			$result = RouteMatch::match($request, $route, $_SERVER['REQUEST_METHOD']);
			if($result['match']){
				$class = new $route['class']();
				$method_name = $route['callable'];
				if($route['type'] == 'function'){					
					if(count($_POST)>0){
						$request = new \Panther\Http\Request;
						foreach($_POST as $key => $value){
							$request->$key = $value;
						}
						return $class->$method_name($request);
					}
					if(count($result['params'])>0){
						return $class->$method_name(...$result['params']);
					}
					return $class->$method_name();
				}else if($route['type'] == 'closure'){					
					if(count($result['params'])>0){
						return $method_name(...$result['params']);
					}
					return $method_name();
				}				
			}
		}
	}

    public function get($url, $callable){    	
    	$trace = debug_backtrace();
    	$class = $trace[1]['class'];
    	if($callable instanceof Closure){
    		$this->routes[] = [
    			'method' => 'GET',
	    		'url' => $url,
	    		'class' => $class,
	    		'type' => 'closure',
	    		'callable' => $callable
	    	];
    	}else{
    		$this->routes[] = [
    			'method' => 'GET',
	    		'url' => $url,
	    		'class' => $class,
	    		'type' => 'function',
	    		'callable' => $callable
	    	];
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