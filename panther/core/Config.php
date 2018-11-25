<?php

namespace Panther\Core;

use Panther\Core\Interfaces\ConfigInterface;

class Config implements ConfigInterface {

    private static $config;

    public static function setup()
    {
        $current = __DIR__;
        $current = str_replace('panther/Core', '', $current);
        if(file_exists($current.'.env')){
            $fh = fopen($current.'.env','r');
            while ($line = fgets($fh)) {
                $tokens = explode('=', $line);
                if(count($tokens)>1)
                    self::$config[$tokens[0]] = trim($tokens[1]);
            }
            fclose($fh);
        }
    }

    public static function has($key)
    {
        if(isset(self::$config[$key]))
            return true;
        return false;
    }

    public static function get($key)
    {
        if(self::has($key))
            return self::$config[$key];
        return '';
    }

    public static function set($key, $value)
    {
        self::$config[$key] = $value;
    }

    public static function toArray()
    {
        return self::$config;
    }

}