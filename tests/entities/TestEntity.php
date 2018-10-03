<?php

namespace Test\Entities;

use Panther\Entity\Entity;
use Panther\Http\Request;

class TestEntity extends Entity {
    
    public function test_get(){
        return 'works';
    }

    public function test_get_id(){
        return 'works';
    }
    
}