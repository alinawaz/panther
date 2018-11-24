<?php

namespace App\Entities;

use Panther\Entity\EntityController;
use Panther\Router\Router;

class TestEntity extends EntityController {

    public function routes(Router $router){	
        $router->get('/test', 'TestEntity@index');
    }

    public function index(){	
        return $this->toJson([ 'Hello from TestEntity' ]);
    }

}