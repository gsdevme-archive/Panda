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

        public function model($name, $value = false)
        {
            if (is_object($value)) {
                $this->_models->$name = $value;
            }
            if (isset($this->_models->$name) ) {
                return $this->_models->$name;
            }
            return false;
        }

    }

    