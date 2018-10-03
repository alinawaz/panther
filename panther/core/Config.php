<?php

namespace Panther\Core;

class Config implements ConfigInterface {

    private $config;

    function __construct($config){
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
        $this->config[$key] = $vaue;
    }

    public function toArray(){
        return $this->config;
    }

}