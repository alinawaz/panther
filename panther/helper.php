<?php

// Common helper
// version@1.0

function resolve($class){
    return new \Panther\Core\Importer($class);
}