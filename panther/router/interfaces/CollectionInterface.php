<?php

namespace Panther\Router\Interfaces;

interface CollectionInterface {
	
    public function push($route);
    
    public function pop();

    public function traverse($request, $callable);
	
}