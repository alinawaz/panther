<?php

namespace App\Entities;

use Panther\Entity\EntityController;
use Panther\Router\Router;

class DatabaseEntity extends EntityController {

    public function routes(Router $router){	
        $router->get('/database', 'DatabaseEntity@index');
    }

    public function index(){	
        return $this->toJson([ 'Hello from DatabaseEntity' ]);
    }

}