<?php

namespace Panther\Router;

class RouteMatch implements RouteMatchInterface {
	
	public static function match($url, $route, $method) {

		// Creating empty object to be returned
		$return = new \StdClass;
		$return->hasParams = false;

		// Slicing up
		$url_slices = explode("/", $url);
		$route_slices = explode("/", $route['url']);

		// Method Match
		if($method != $route['method']){
			$return->matched = false;
			$return->message = "Invalid Request Method ".$method;
			return $return;
		}

		// Length Match
		if(count($url_slices) != count($route_slices)){
			$return->matched = false;
			$return->message = "Length Not Equal";
			return $return;
		}

		// Slice by slice match
		$params = [];
		for ($i=0; $i < count($url_slices); $i++) { 
			$url_slice = $url_slices[$i];
			$route_slice = $route_slices[$i];

			//checking for params
			if (strpos($route_slice, ':') !== false) {
				$params[] = $url_slice;
			}else{
				// Exact match
				if($route_slice != $url_slice){
					$return->matched = false;
					$return->message = "No Exact Match Between R{".$route_slice."} And U{".$url_slice."}";
					return $return;
				}
			}
		}

		$return->matched = true;
		$return->params = $params;
		$return->hasParams = true;
		
		return $return;
	}

}