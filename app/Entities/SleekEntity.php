<?php

namespace App\Entities;

use Panther\Entity\EntityController;
use Panther\Router\Router;

use App\Models\Item;

class SleekEntity extends EntityController {

    public function routes(Router $router){	
        $router->get('/sleek', 'SleekEntity@index');
    }

    public function index(){	
        return $this->view('sleek', [
        	'items' => Item::all()
        ]);
    }

}