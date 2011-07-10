<?php

    namespace Core;

use Core\Exceptions\ViewException as Exception;

    class View
    {

        private $_panda;
        private $_registry;

        public function __construct()
        {
            $this->_panda = Panda::getInstance();
            $this->_registry = Registry::getInstance();
        }

        public function load($name, array $args = null, $shared = false)
        {
            if ($shared) {
                $file = $this->_panda->root . '/Shared/Views/' . $name . '.php';
            } else {
                $file = $this->_panda->appRoot . 'Views/' . $name . '.php';
            }
            if (is_readable($file)) {

                if (is_array($args)) {
                    extract($args);
                }

                require $file;
                return true;
            }
            throw new Exception('Failed to load ' . $name);
        }

        public function element($name)
        {
            
        }

    }