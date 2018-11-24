<?php

namespace Panther\Core;

use Panther\Core\Interfaces\ConfigInterface;

class Config implements ConfigInterface {

    private $config;

    function __construct($config = []){
        $this->config = $config;
    }

    public function readFromEnv(){
        $current = __DIR__;
        $current = str_replace('panther/Core', '', $current);
        $fh = fopen($current.'.env','r');
        while ($line = fgets($fh)) {
            $tokens = explode('=', $line);
            if(count($tokens)>1)
                $this->config[$tokens[0]] = trim($tokens[1]);
        }
        fclose($fh);
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