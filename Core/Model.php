<?php

    namespace Core;

    abstract class Model
    {

        private $_registry;

        public function __construct()
        {
            $this->_registry = Registry::getInstance();
        }

        /**
         *
         * @param type $name
         * @return type 
         */
        public function __get($name)
        {
            return $this->modules($name);
        }

        public function modules($name)
        {
            if(($module = $this->_registry->modules($name))){
                return $module;
            }
            
            $class = '\Etc\Modules\\' . $name;
            
            return $this->_registry->modules($name, new $class);
        }

    }

    