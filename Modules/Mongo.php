<?php

    namespace Modules;

    class Mongo
    {

        private static $_instance;
        private $_mongo;

        private function __construct()
        {
            try {
                $this->_mongo = new \Mongo();
                return;
            } catch (\Exception $e) {
                
            }

            throw new \Core\Exceptions\ModuleException('Failed to create Mongo instance, do you have it installed ? ', null, $e, 500);
        }

        public static function getInstance()
        {
            if (!self::$_instance instanceof self) {
                self::$_instance = new self;
            }

            return self::$_instance;
        }

        public function __call($method, $args)
        {
            return call_user_func_array(array($this->_mongo, $method), $args);
        }

        public function __get($name)
        {
            return $this->_mongo->$name;
        }

    }