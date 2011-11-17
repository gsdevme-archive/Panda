<?php

    namespace Core;

use Core\Exceptions\RegistryException as Exception;

    class Registry extends RegistryAbstract
    {

        protected static $_instance;
        private $_models, $_libraries, $_serviceLayers, $_helpers, $_modules;

        public function __construct()
        {
            $this->_models = new \stdClass();
            $this->_libraries = new \stdClass();
            $this->_serviceLayers = new \stdClass();
            $this->_helpers = new \stdClass();
            $this->_modules = new \stdClass();
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
         * Add or get a validation
         * @param string $name name of validation
         * @param object $value optional validation object
         * @return object
         */
        public function validations($name, $value = false)
        {
            return $this->_accessor($name, '_validations', $value);
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

        /**
         * Adds or gets a helper
         * @param string $name
         * @param object $value
         * @return object 
         */
        public function helpers($name, $value = false)
        {
            return $this->_accessor($name, '_helpers', $value);
        }

        /**
         * Adds or gets a modules
         * @param string $name
         * @param object $value
         * @return object 
         */
        public function modules($name, $value = false)
        {
            return $this->_accessor($name, '_modules', $value);
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
            
            return ( bool ) false;
        }

    }

    