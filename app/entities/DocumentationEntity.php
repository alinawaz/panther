<?php

namespace App\Entities;

use Panther\Entity\EntityController;
use Panther\Router\Router;

class DocumentationEntity extends EntityController {

    public function routes(Router $router){	
        $router->get('/documentation', 'DocumentationEntity@index');
    }

    public function index(){	
        return $this->view('documentation.layout.app');
    }

}