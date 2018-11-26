<?php

namespace App\Entities;

use Panther\Entity\EntityController;
use Panther\Router\Router;

class Entity extends EntityController {

    public function routes(Router $router){	
        $router->get('/User', 'Entity@index');
    }

    public function index(){	
        return $this->toJson([
        	'status' => true,
        	'message' => 'Hello from Entity!'
        ]);
    }

}