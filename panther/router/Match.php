<?php

namespace Panther\Router;

use \Panther\Router\Interfaces\MatchInterface;

class Match implements MatchInterface {
	
	public static function match($route, $request) {

		// Creating empty object to be returned
		$return = new \StdClass;
		$return->hasParams = false;

		// Slicing up
		$url_slices = explode("/", $request->request_string);
		$route_slices = explode("/", $route->getUrl());

		// Method Match
		if($request->getMethod() != $route->getMethod()){
			$return->matched = false;
			$return->message = "Invalid Request Method ".$request->getMethod();
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