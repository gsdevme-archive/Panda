<?php

namespace Core;

abstract class RegistryAbstract
{
    
    private static $_instance;
    
    /**
     * Get an instance of a registry
     * @return RegistryAbstract
     */
    public static function getInstance()
    {
        if(!static::$_instance instanceof static){
            static::$_instance = new static;
        }
        return static::$_instance;
    }
}
