<?php

namespace Panther\Core\Interfaces;

interface ConfigInterface {
    
    public static function has($key);

    public static function get($key);

    public static function set($key, $value);

    public static function toArray();

}