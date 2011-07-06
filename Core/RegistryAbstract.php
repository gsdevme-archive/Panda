<?php

namespace Core;

abstract class RegistryAbstract
{
    
    private static $_instance;
    
    private $_store;
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
    
    /**
     * Import an associative array or stdClass
     * @param type $data 
     */
    public function import($data)
    {
        foreach($data as $k=>$v){
            $this->$k = $v;
        }
    }
}
