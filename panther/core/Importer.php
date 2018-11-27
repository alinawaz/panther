<?php

namespace Panther\Core;

use Panther\Core\Interfaces\ImporterInterface;

class Importer implements ImporterInterface {

    public function resolve($context, $constructor = NULL){
        $path = $this->buildPath($context);
        return new $path($constructor);
    }

    private function buildPath($context){
    	$path = '\\Panther';
    	$context_array = explode('.', $context);
    	foreach($context_array as $ctx){
    		$path .= '\\' . ucwords($ctx);
    	}
        return $path;
    }

}