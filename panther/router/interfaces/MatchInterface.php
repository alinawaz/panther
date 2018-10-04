<?php

namespace Panther\Router\Interfaces;

interface MatchInterface {
	
	public static function match($route, $request);
	
}