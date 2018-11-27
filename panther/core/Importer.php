<?php

namespace Panther\Core;

use Panther\Core\Interfaces\ImporterInterface;

use Panther\Core\ErrorView;

class Importer implements ImporterInterface {

    public function resolve($context, $constructor = NULL){
        $path = $this->buildPath($context);
        if(!class_exists($path))
            ErrorView::render('Importer Exception','Unable to resolve <code>'.$path.'</code>');
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