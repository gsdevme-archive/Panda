<?php

    namespace Core;

    class View
    {

        private $_args;

        public function __construct($file, array $args=null)
        {
            if ($args !== null) {
                $this->_args = $args;
                extract($this->_args);
            }

            require $file;
        }

        /**
         * Load an element
         * @param string $name
         * @param bool $shared 
         */
        public function element($name, $shared = false)
        {
            if ($shared === true) {
                $file = Panda::getInstance()->root . '/Shared/Elements/' . $name . '.php';
            } else {
                $file = Panda::getInstance()->appRoot . 'Elements/' . $name . '.php';
            }

            if (is_readable($file)) {
                if (is_array($this->_args)) {                    
                    extract($this->_args);
                }
                require $file;
            } else {
                throw new Exception('Element not found - ' . $file);
            }
        }

    }