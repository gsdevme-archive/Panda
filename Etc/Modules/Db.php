<?php

    namespace Etc\Modules;

    class Db implements iDb
    {

        private static $_instance;

        private function __construct()
        {
            
        }

        public static function getInstance()
        {
            if (!self::$_instance instanceof self) {
                self::$_instance = new self;
            }

            return self::$_instance;
        }
        
        public function query(){
            
        }

    }

    