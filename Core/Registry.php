<?php

    namespace Core;

use Core\Exceptions\RegistryException as Exception;

    class Registry extends RegistryAbstract
    {

        protected static $_instance;
        private $_models;
        private $_libraries;
        private $_serviceLayers;

        public function __construct()
        {
            $this->_models = new \stdClass();
            $this->_libraries = new \stdClass();
            $this->_serviceLayers = new \stdClass();
        }

        public function models($name, $value = false)
        {
            return $this->_accessor($name, '_models', $value);
        }

        public function libraries($name, $value = false)
        {
            return $this->_accessor($name, '_libraries', $value);

        }

        public function serviceLayers($name, $value = false)
        {
            return $this->_accessor($name, '_serviceLayers', $value);
        }

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

    