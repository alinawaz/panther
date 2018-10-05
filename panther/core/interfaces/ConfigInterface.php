<?php

namespace Panther\Core\Interfaces;

interface ConfigInterface {

    public function mock($config);
    
    public function has($key);

    public function get($key);

    public function set($key, $value);

    public function toArray();

}