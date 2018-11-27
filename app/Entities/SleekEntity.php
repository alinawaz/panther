<?php

namespace App\Entities;

use Panther\Entity\EntityController;
use Panther\Router\Router;

class SleekEntity extends EntityController {

    public function routes(Router $router){	
        $router->get('/sleek', 'SleekEntity@index');
    }

    public function index(){	
        return $this->view('sleek', [
        	'test' => '123',
        	'items' => ['item1', 'item2', 'item3']
        ]);
    }

}