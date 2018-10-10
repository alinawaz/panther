<?php

namespace Panther\Core;

use Panther\Core\Interfaces\ConfigInterface;

class Config implements ConfigInterface {

    private $config;

    function __construct($config = []){
        $this->config = $config;
    }

    public function mock($config){
        $this->config = $config;
        return $this;
    }

    public function has($key){
        if(isset($this->config[$key]))
            return true;
        return false;
    }

    public function get($key){
        return $this->config[$key];
    }

    public function set($key, $value){
        $this->config[$key] = $value;
    }

    public function toArray(){
        return $this->config;
    }

}