<?php

namespace Test\Entities;

use Panther\Entity\EntityController;
use Panther\Http\Request;

class TestEntity extends EntityController {
    
    public function test_get(){
        return 'works';
    }

    public function test_get_param($char){
        return 'work'.$char; // work+s = works
    }

    public function test_post($request){
        return $request->string; // works
    }

    public function test_post_param($char, $request){
        return $request->string.$char; // work+s = works
    }
    
}