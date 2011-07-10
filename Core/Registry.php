<?php

    namespace Core;

use Core\Exceptions\RegistryException as Exception;

    class Registry extends RegistryAbstract
    {

        protected static $_instance;
        
        private $_models;
        private $_libraries;
        private $_serviceLayers;
        private $_views;

        public function __construct()
        {
            $this->_models = new \stdClass();
            $this->_libraries = new \stdClass();
            $this->_serviceLayers = new \stdClass();
            $this->_views = new \stdClass();
        }
        /**
         * Add or get a model
         * @param string $name name of model
         * @param object $value optional modal object
         * @return object
         */
        public function models($name, $value = false)
        {
            return $this->_accessor($name, '_models', $value);
        }
        
        /**
         * Add or get a library
         * @param string $name name of library
         * @param object $value optional library object
         * @return object
         */
        public function libraries($name, $value = false)
        {
            return $this->_accessor($name, '_libraries', $value);

        }
        
        /**
         * Add or get a service layer
         * @param string $name name of service layer
         * @param object $value optional service layer object
         * @return object
         */
        public function serviceLayers($name, $value = false)
        {
            return $this->_accessor($name, '_serviceLayers', $value);
        }
        
        public function views($name,$value = false)
        {
            return $this->_accessor(sha1($name), '_views', $value);
        }
        /**
         * Method to get or set items to the storage objects
         * @param string $name of the object
         * @param string $store name of store e.g '_models'
         * @param object $value optional object to set
         * @return object 
         */
        private function _accessor($name, $store, $value = false)
        {
            if (is_object($value)) {
                $this->$store->$name = $value;
            }
            if (isset($this->$store->$name)) {
                return $this->$store->$name;
            }
            return false;
        }

    }

    