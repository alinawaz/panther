<?php

namespace Panther\Router;

interface RouteMatchInterface {
	
	public static function match($url, $route, $method);
	
}