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
            if (is_object($value)) {
                $this->_models->$name = $value;
            }
            if (isset($this->_models->$name)) {
                return $this->_models->$name;
            }
            return false;
        }

        public function libraries($name, $value = false)
        {
            if (is_object($value)) {
                $this->_libraries->$name = $value;
            }
            if (isset($this->_libraries->$name)) {
                return $this->_libraries->$name;
            }
            return false;
        }

        public function serviceLayers($name, $value = false)
        {
            if (is_object($value)) {
                $this->_serviceLayers->$name = $value;
            }
            if (isset($this->_serviceLayers->$name)) {
                return $this->_serviceLayers->$name;
            }
            return false;
        }

    }

    