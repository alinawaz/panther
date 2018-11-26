<?php

namespace App\Entities;

use Panther\Entity\EntityController;
use Panther\Router\Router;

class UserEntity extends EntityController {

    public function routes(Router $router){	
        $router->get('/user', 'UserEntity@index');
    }

    public function index(){	
        return $this->toJson([
        	'status' => true,
        	'message' => 'Hello from UserEntity!'
        ]);
    }

}