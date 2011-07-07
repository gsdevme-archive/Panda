<?php

    namespace Core;

use Core\Exceptions\RegistryException as Exception;

    /**
     * Each deriving class needs:
     * protected static $_instance;
     */
    abstract class RegistryAbstract
    {

        private static $_instance;
        private $_store;

        /**
         * @access Private
         * Constructor to assign a stdClass 
         */
        private function __construct()
        {
            $this->_store = new \stdClass;
        }

        /**
         * Get an instance of a registry
         * @return RegistryAbstract
         */
        public static function getInstance()
        {
            if (!static::$_instance instanceof static) {
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
            if ($data !== null) {
                foreach ($data as $k => $v) {
                    $this->_store->$k = $v;
                }
            }


            return static::$_instance;
        }

        /**
         * Sets values within the store
         * @param string $name
         * @param mixed $value 
         */
        public function __set($name, $value)
        {
            $this->_store->$name = $value;
        }

        /**
         * Gets value within the store
         * @param string $name
         * @return mixed 
         */
        public function __get($name)
        {
            return ifsetor($this->_store->$name, null);
        }

    }