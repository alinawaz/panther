<?php

namespace App\Routing;

class Routes {

    private $router;

    function __construct($router){
        $this->router = $router;
    }

    public function index(){
        $this->router->get('/', 'HelloEntity@index');        
    }

}