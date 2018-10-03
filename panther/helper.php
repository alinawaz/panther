<?php

// Common helper
// version@1.0

$global_config = null;

function config($key=null){
    if($key == null)
        return $global_config;
    return $global_config->get($key);
}

function resolve($class){
    return new \Panther\Core\Importer($class);
}