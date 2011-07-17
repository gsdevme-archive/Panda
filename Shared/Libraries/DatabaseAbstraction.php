<?php

    namespace Libraries;

use \Core\Panda as Panda;

    class DatabaseAbstraction
    {

        private static $_instance;
        private $_panda;

        private function __construct(Panda $panda)
        {
            $this->_panda = $panda;
        }

        public static function getInstance(Panda $panda=null)
        {
            if (!self::$_instance instanceof self) {
                self::$_instance = new self($panda);
            }

            return self::$_instance;
        }

    }

    