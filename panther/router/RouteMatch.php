<?php

namespace Panther\Router;

class RouteMatch implements RouteMatchInterface {
	
	public static function match($url, $route, $method) {

		// Slicing up
		$url_slices = explode("/", $url);
		$route_slices = explode("/", $route['url']);

		// Method Match
		if($method != $route['method']){
			return [
				"match" => false,
				"reason" => "Invalid Request Method ".$method
			];
		}

		// Length Match
		if(count($url_slices) != count($route_slices)){
			return [
				"match" => false,
				"reason" => "Length Not Equal"
			];
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
					return [
						"match" => false,
						"reason" => "No Exact Match Between R{".$route_slice."} And U{".$url_slice."}"
					];
				}
			}
		}

		return [
			"match" => true,
			"params" => $params
		];
	}

}